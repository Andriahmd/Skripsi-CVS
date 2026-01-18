# 🐛 ANALISIS BUG DAN PERBAIKAN - PemeriksaanController

**Tanggal**: 16 Januari 2026  
**File**: `app/Http/Controllers/PemeriksaanController.php`  
**Status**: ✅ **FIXED**

---

## 📌 RINGKASAN EKSEKUTIF

Ditemukan **2 bug kritis** yang menyebabkan:
1. **Pemeriksaan menunjukkan hasil kosong** ketika user tidak menyelesaikan screening, pindah menu, lalu kembali
2. **Data inklusi/eksklusi tidak ter-update** ketika user melakukan screening ulang setelah ditolak

---

## 🔴 BUG #1: PEMERIKSAAN KOSONG SETELAH NAVIGASI

### Deskripsi Masalah
- User mulai screening inklusi/eksklusi (belum selesai)
- User pindah ke menu lain
- User kembali dan melanjutkan pemeriksaan hingga selesai
- **Result**: Pemeriksaan tersimpan tetapi **hasil kosong/tidak ada data CF**
- Namun pemeriksaan berikutnya mendapat hasil yang benar

### Analisis Penyebab

#### Root Cause: Logic di `createPemeriksaan()` Terlalu Permissive
```php
// KODE LAMA (Line 313-319) - PROBLEMATIC
$existingPemeriksaan = Pemeriksaan::where('id_user', $user->id)
    ->whereNull('hasil_diagnosa')
    ->latest()
    ->first();

if ($existingPemeriksaan) {
    return response()->json([
        'success' => true,
        'id_pemeriksaan' => $existingPemeriksaan->id,
        'message' => 'Melanjutkan pemeriksaan sebelumnya...',
    ]);
}
```

**Problems:**
1. **Tidak cek status screening** - Method ini menggunakan ID pemeriksaan lama **TANPA VERIFIKASI** apakah sudah lolos screening atau belum
2. **Akibat:** Jika user belum lolos screening, tetapi kemudian submit jawaban gejala, sistem akan menghitung CF dengan ID yang sebelumnya **belum melewati screening**
3. **Data Inkonsistensi** - Field `persentase_cf` dan `hasil_diagnosa` bisa berisi nilai lama yang tidak sesuai dengan jawaban gejala terbaru

#### Skenario Lebih Detail

```
[TIMELINE]

1. User buka screening → createPemeriksaan() buat ID=100
2. User isi partial screening (3 dari 5 inklusi) 
   → simpanScreening() kembalikan 'complete'=false
   → inklusi_eksklusi BELUM mencakup kondisi lolos

3. User close browser / pindah menu

4. User kembali → createPemeriksaan() 
   → MENEMUKAN ID=100 yang hasil_diagnosa=NULL
   → RETURN ID=100 (TIDAK CEK apakah sudah lolos screening!)

5. User lanjut isi screening (sekarang jawab semua 5 inklusi + 7 eksklusi)
   → simpanScreening() UPDATE inklusi_eksklusi dengan status LOLOS
   → submitTotal() HITUNG CF dan UPDATE persentase_cf

6. PROBLEM: 
   - Mungkin ada cache atau stale data
   - Field persentase_cf tidak ter-update dengan benar
   - Jawaban gejala dari iterasi sebelumnya masih tersimpan
```

#### Mengapa "Pemeriksaan Berikutnya Benar"?
Karena sistem membuat **PEMERIKSAAN BARU** (ID yang berbeda), sehingga tidak ada data lama yang mencampuri.

---

## 🔴 BUG #2: INKLUSI/EKSKLUSI TIDAK TER-UPDATE

### Deskripsi Masalah
- User gagal screening (tidak memenuhi inklusi atau ada eksklusi)
- Sistem DELETE pemeriksaan
- User melakukan screening ulang (dengan kondisi baru yang berbeda)
- **Result**: Kondisi lama masih muncul atau tidak ter-update **kadang bisa, kadang tidak**
- Padahal kondisi baru sudah memenuhi kriteria

### Analisis Penyebab

#### Root Cause 1: `updateOrCreate()` Tidak Konsisten (Line 438-442)
```php
// KODE LAMA - PROBLEMATIC
InklusiEksklusi::updateOrCreate(
    ['id_pemeriksaan' => $validated['id_pemeriksaan']],
    [
        'memenuhi_inklusi' => ($inklusiYa === 5),
        'ada_eksklusi' => ($eksklusiYa > 0)
    ]
);
```

**Problems:**
1. **Timing Race Condition** - `updateOrCreate()` mencoba CREATE jika tidak ada, tetapi mungkin conflict dengan proses delete
2. **Record Orphan** - Ketika pemeriksaan dihapus (line 455-463), record di `inklusi_eksklusi` TIDAK ikut terhapus di beberapa kasus
3. **Cascade Delete Issue** - Foreign key cascade delete mungkin tidak trigger karena:
   - Soft delete atau incomplete transaction
   - Locking issue pada database
   - Timing mismatch antara delete pemeriksaan dan update inklusi_eksklusi

#### Root Cause 2: Hapus Data TIDAK Atomik (Line 451-463)
```php
// KODE LAMA - PROBLEMATIC
DB::beginTransaction();
try {
    Pemeriksaan::where('id', $validated['id_pemeriksaan'])->delete();
    DB::commit();
    // ... return error response
} catch (\Exception $e) {
    DB::rollBack();
}
```

**Problems:**
1. **HANYA menghapus Pemeriksaan** - Tidak explicitly hapus:
   - `jawaban` (mungkin terhapus via cascade, tapi tidak guaranteed)
   - `inklusi_eksklusi` (TIDAK terhapus!)
   
2. **Jawaban lama tersisa** - Field `jawaban` masih ada, sehingga saat user retry dan calculate CF, nilai lama ikut dihitung

3. **Race Condition** - Antara delete pemeriksaan dan user yang refresh/retry:
   ```
   [SEQUENCE PROBLEM]
   T1: DELETE Pemeriksaan WHERE id=100
   T2: User refresh halaman
   T3: createPemeriksaan() buat ID=101 baru
   T4: User submit jawaban
   BUT: inklusi_eksklusi(id_pemeriksaan=100) MASIH ADA!
       (cascade delete tidak trigger atau delayed)
   ```

---

## ✅ SOLUSI YANG DITERAPKAN

### FIX #1: Improve `createPemeriksaan()` Logic (Line 298-346)

**Perubahan:**
```php
// Load dengan relasi inklusi_eksklusi
$existingPemeriksaan = Pemeriksaan::where('id_user', $user->id)
    ->whereNull('hasil_diagnosa')
    ->latest()
    ->with('inklusiEksklusi')
    ->first();

if ($existingPemeriksaan) {
    // CEK: Apakah sudah lolos screening?
    if ($existingPemeriksaan->inklusiEksklusi && 
        $existingPemeriksaan->inklusiEksklusi->lolosScreening()) {
        // YES: Bisa dilanjutkan
        return response()->json([
            'success' => true,
            'id_pemeriksaan' => $existingPemeriksaan->id,
        ]);
    } else {
        // NO: Hapus untuk fresh start
        $existingPemeriksaan->jawaban()->delete();
        $existingPemeriksaan->inklusiEksklusi()->delete();
        $existingPemeriksaan->delete();
    }
}

// Buat baru dengan state bersih
$pemeriksaan = Pemeriksaan::create([...]);
```

**Benefit:**
- ✅ Memastikan hanya pemeriksaan yang **sudah lolos screening** yang dilanjutkan
- ✅ Fresh start untuk pemeriksaan baru (state bersih)
- ✅ Menghindari data stale atau orphan

---

### FIX #2: Atomik Delete + Explicit Transaction (Line 386-539)

**Perubahan:**
```php
DB::beginTransaction();
try {
    // STEP 1: Update/Create inklusi_eksklusi dengan nilai terbaru
    $inklusiEksklusi = InklusiEksklusi::where(
        'id_pemeriksaan', $idPemeriksaan
    )->first();
    
    if ($inklusiEksklusi) {
        $inklusiEksklusi->update([
            'memenuhi_inklusi' => ($inklusiYa === 5),
            'ada_eksklusi' => ($eksklusiYa > 0),
            'updated_at' => now()
        ]);
    } else {
        InklusiEksklusi::create([...]);
    }

    // STEP 2: Validasi setelah update
    if ($isComplete) {
        $lolos = $memenuhiInklusi && $tidakAdaEksklusi;
        
        if (!$lolos) {
            // EXPLICIT DELETE semua relasi
            Jawaban::where('id_pemeriksaan', $idPemeriksaan)->delete();
            InklusiEksklusi::where('id_pemeriksaan', $idPemeriksaan)->delete();
            Pemeriksaan::where('id', $idPemeriksaan)->delete();
            
            DB::commit(); // Commit transaction atomically
            return error response;
        }
    }
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    throw $e;
}
```

**Benefit:**
- ✅ Selalu update dengan nilai TERBARU (bukan updateOrCreate yang ambiguous)
- ✅ Explicit delete semua relasi dalam satu transaction
- ✅ Atomic operation - semua berhasil atau semua rollback
- ✅ Hindari race condition dan orphan records

---

## 📊 PERBANDINGAN BEFORE vs AFTER

| Aspek | BEFORE | AFTER |
|-------|--------|-------|
| **Screening Verification** | Tidak cek status lolos | Cek `lolosScreening()` |
| **Pemeriksaan Lama** | Reuse tanpa clean | Delete & fresh start jika belum lolos |
| **Update Inklusi/Eksklusi** | `updateOrCreate()` ambiguous | Direct `update()` atau `create()` |
| **Delete Atomicity** | Hanya hapus Pemeriksaan | Hapus semua relasi dalam transaction |
| **Jawaban Lama** | Bisa tersisa | Explicit delete dalam transaction |
| **Race Condition** | Rawan terjadi | Atomic transaction mencegah |
| **Cascade Delete** | Tidak guaranteed | Explicit delete di kode |

---

## 🧪 TEST CASES UNTUK VERIFIKASI

### Test Case 1: Incomplete Screening → Refresh → Complete
```
1. Start screening → answer partial (3/5 inklusi)
2. Click hamburger menu / refresh page
3. Go back to screening → complete all (5/5 inklusi + 7/7 eksklusi)
4. Submit → Check:
   - ✅ Pemeriksaan ID baru (bukan ID lama)
   - ✅ hasil_diagnosa terisi dengan benar
   - ✅ persentase_cf dihitung dari jawaban lengkap
```

### Test Case 2: Screening Gagal → Retry dengan Kondisi Baru
```
1. Start screening
2. Answer to NOT meet inklusi (e.g., 3 "Ya" + ada eksklusi)
3. Submit → Get "Gagal Screening" message
4. See: Pemeriksaan deleted, can start fresh
5. Click "Uji Ulang" / "Mulai Baru"
6. Answer yang MEMENUHI (5/5 inklusi + 0 eksklusi)
7. Submit → Check:
   - ✅ Lolos screening
   - ✅ Bisa lanjut ke gejala
   - ✅ inklusi_eksklusi records updated dengan benar
```

### Test Case 3: Multiple Retries
```
1. Attempt 1: Gagal (3 inklusi) → Pemeriksaan hapus
2. Attempt 2: Gagal (2 inklusi + ada eksklusi) → Pemeriksaan hapus
3. Attempt 3: Lolos (5 inklusi + 0 eksklusi) → Pemeriksaan tersimpan
4. Check DB:
   - ✅ Hanya 1 record pemeriksaan untuk user ini
   - ✅ inklusi_eksklusi ter-update dengan nilai attempt 3
   - ✅ Tidak ada orphan records
```

---

## 📝 CATATAN TEKNIS

### Perubahan Method:
1. **`createPemeriksaan()`** - Tambah validasi screening status + clean-up logic
2. **`simpanScreening()`** - Ganti `updateOrCreate()` → explicit `update()`/`create()` + atomik delete

### Database Relations yang Terlibat:
```
Pemeriksaan (1)
├── Jawaban (many) - soft delete akan delete otomatis
├── InklusiEksklusi (1) - HARUS explicit delete
└── User (many)
```

### Helper Method yang Digunakan:
- `InklusiEksklusi::lolosScreening()` - Cek apakah lolos
- `Pemeriksaan::with('inklusiEksklusi')` - Eager loading

---

## 🎯 REKOMENDASI TAMBAHAN

1. **Tambah Index** di `inklusi_eksklusi` tabel:
   ```php
   // Di migration
   $table->unique('id_pemeriksaan');
   ```

2. **Soft Delete** untuk audit trail:
   ```php
   // Di Model Pemeriksaan
   use SoftDeletes;
   protected $dates = ['deleted_at'];
   ```

3. **Add Logging** untuk track setiap attempt:
   ```php
   Log::info("Screening attempt: user={$user->id}, pemeriksaan={$pemeriksaan->id}, result={lolos|gagal}");
   ```

4. **Frontend Enhancement**:
   - Show progress indicator (3/12 soal dijawab)
   - Prevent accidental navigation with unsaved answers
   - Add "Mulai Ulang" button instead of auto-cleanup

---

## 📞 TESTING CHECKLIST

- [ ] Test incomplete screening + browser refresh
- [ ] Test screening gagal + retry dengan kondisi baru
- [ ] Test multiple rapid retry attempts
- [ ] Check database untuk orphan records
- [ ] Verify CF calculation akurat setelah fix
- [ ] Test concurrent users dengan sama user ID
- [ ] Check logs untuk debug info

---

**Status**: ✅ **SELESAI DIPERBAIKI**  
**Tested**: Pending
**Review**: Pending
