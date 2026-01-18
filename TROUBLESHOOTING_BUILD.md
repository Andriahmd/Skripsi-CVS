# 🔧 TROUBLESHOOTING - Build Masih Bug Setelah Fix

## ⚡ LANGKAH-LANGKAH CLEAR CACHE & REBUILD

### 1️⃣ STEP 1: Clear Semua Laravel Cache (✅ SUDAH DILAKUKAN)
```bash
php artisan cache:clear
php artisan config:clear  
php artisan view:clear
php artisan optimize:clear
```
✅ Status: **DONE**

---

### 2️⃣ STEP 2: Clear Browser Cache (⏳ MANUAL)
```
Chrome/Edge: Ctrl + Shift + Delete
Firefox: Ctrl + Shift + Delete
Safari: Cmd + Shift + Delete

Atau:
1. Settings → Privacy
2. Clear browsing data
3. Check: Cookies, Cache, Site data
4. Time range: All time
5. Clear
```

**ATAU** buka di Incognito/Private mode buat test

---

### 3️⃣ STEP 3: Stop Services & Restart

Jika pakai **Laragon**:
```
1. Click "Stop All" di Laragon
2. Wait 2-3 detik
3. Click "Start All"
4. Wait sampai semua hijau
```

Jika pakai **Command Line**:
```bash
# Kill PHP process
taskkill /F /IM php.exe

# Restart
php artisan serve
```

---

### 4️⃣ STEP 4: Verify Kode Sudah Update

**Buka file untuk cek:**
```
app/Http/Controllers/PemeriksaanController.php
```

Cari baris ~301, harus ada:
```php
// BUG FIX #1: Cek pemeriksaan yang belum selesai screening
$existingPemeriksaan = Pemeriksaan::where('id_user', $user->id)
    ->whereNull('hasil_diagnosa')
    ->latest()
    ->with('inklusiEksklusi')  // ← Ini harus ada (NEW)
    ->first();

if ($existingPemeriksaan) {
    // Cek apakah sudah lolos screening (NEW)
    if ($existingPemeriksaan->inklusiEksklusi && 
        $existingPemeriksaan->inklusiEksklusi->lolosScreening()) {
```

✅ Jika ada = kode sudah update  
❌ Jika tidak ada = kode belum update, check git status

---

### 5️⃣ STEP 5: Check Database State (Optional tapi Recommended)

**Opsi A: Pake Filament/Panel**
```
1. Login ke admin
2. Navigate ke resources untuk check data
3. Lihat apakah ada data "Ditolak" yang old
```

**Opsi B: Pake Command Line**
```bash
# Connect ke database
php artisan tinker

# Cek pemeriksaan lama
>>> App\Models\Pemeriksaan::where('id_user', 1)->get()
>>> App\Models\InklusiEksklusi::get()

# Hapus data yang problematic (jika perlu)
>>> App\Models\Pemeriksaan::where('id_user', 1)->delete()
>>> App\Models\InklusiEksklusi::where('id_pemeriksaan', '<id>')->delete()
```
```

---

### 6️⃣ STEP 6: Test Ulang (Fresh)

1. **Logout semua user**
2. **Login user baru ATAU clear session**
   ```bash
   php artisan session:clear
   ```
3. **Buka incognito window**
4. **Test screening workflow:**
   - Isi partial screening (3/5 inklusi)
   - Refresh halaman
   - Lanjut isi screening (sampai 5/5 + 7/7)
   - Submit
   - Check hasil: ✅ Harus ada hasil yang akurat

---

## 🔍 TROUBLESHOOTING CHECKLIST

### Masih Bug Setelah Langkah di atas?

#### Problem: "Masih hasil kosong"
- [ ] Verify kode BUG FIX #1 & #2 exist
- [ ] Clear browser cache (bukan hanya history)
- [ ] Try incognito window
- [ ] Check logs: `tail -f storage/logs/laravel.log`
- [ ] Verify `inklusiEksklusi` table punya data
- [ ] Try create NEW user & test from scratch

#### Problem: "Screening gagal tidak hapus data"
- [ ] Check database: Apakah `pemeriksaan` & `inklusi_eksklusi` ada orphan records?
- [ ] Verify BUG FIX #2 implement: Explicit delete dalam transaction
- [ ] Check: Apakah `jawaban` table juga orphan?
- [ ] Cek error log: `storage/logs/laravel.log`

#### Problem: "Update tidak konsisten"
- [ ] Verify transaction wrapping di simpanScreening()
- [ ] Check: Apakah `DB::beginTransaction()` dijalankan?
- [ ] Verify commit/rollback terjadi
- [ ] Try 2-3x retry untuk consistency test

---

## 📋 QUICK COMMANDS

```bash
# Clear everything
php artisan cache:clear && php artisan config:clear && php artisan view:clear && php artisan optimize:clear

# Tail logs
tail -f storage/logs/laravel.log

# Clear sessions
php artisan session:clear

# Flush database (WARNING: DATA HILANG!)
php artisan migrate:fresh --seed

# Test pake tinker
php artisan tinker
> \App\Models\Pemeriksaan::all()
> \App\Models\InklusiEksklusi::all()
```

---

## 🎯 HASIL YANG DIHARAPKAN

### Sebelum Fix ❌
```
1. Partial screening → pindah menu → lengkapi screening
   Result: Kosong / Tidak ada hasil
   
2. Screening gagal → retry dengan kondisi lolos
   Result: Kondisi lama masih ada, tidak ter-update
```

### Setelah Fix ✅
```
1. Partial screening → pindah menu → lengkapi screening
   Result: Hasil akurat dengan CF benar
   
2. Screening gagal → retry dengan kondisi lolos
   Result: Data lama di-delete, data baru ter-update konsisten
```

---

## 📞 DEBUG TIPS

### Enable Debug Mode (development only)
```php
// .env
APP_DEBUG=true
APP_ENV=local
```

### Add Logging
Kode sudah include:
```php
Log::info("..."); // Akan tampil di storage/logs/laravel.log
```

Monitor real-time:
```bash
tail -f storage/logs/laravel.log | grep "SCREENING"
```

---

**Last Updated**: 17 Jan 2026  
**Status**: Ready for testing
