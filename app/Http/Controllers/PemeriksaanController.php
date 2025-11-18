<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Jawaban;
use App\Models\Gejala;
use App\Models\InklusiEksklusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PemeriksaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 📋 Data pertanyaan screening (hardcoded)
     */
    private function getPertanyaanScreening()
    {
        return [
            'inklusi' => [
                1 => 'Apakah Anda bekerja atau sering beraktivitas di depan layar komputer setiap hari?',
                2 => 'Apakah durasi penggunaan layar Anda lebih dari 3–4 jam dalam satu hari?',
                3 => 'Apakah pencahayaan di tempat Anda bekerja sering tidak sesuai (terlalu terang atau terlalu redup)?',
                4 => 'Apakah Anda jarang mengistirahatkan mata saat menggunakan komputer?',
                5 => 'Apakah jarak pandang Anda ke layar biasanya kurang dari 60–50 cm?',
            ],
            'eksklusi' => [
                6 => 'Apakah Anda memiliki riwayat kelainan refraksi berat atau sering berganti kacamata?',
                7 => 'Apakah Anda memiliki kelainan anatomi pada bola mata (misalnya bentuk kornea abnormal)?',
            ],
        ];
    }

    /**
     * 🏠 Tampilkan form pemeriksaan
     */
    public function showForm()
    {
        return view('pertanyaan');
    }

    /**
     * ✅ Buat pemeriksaan baru
     */
   /**
     * ✅ Buat pemeriksaan baru (Smart Create)
     * Mencegah spam data NULL jika user refresh halaman
     */
    public function createPemeriksaan(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user->umur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan lengkapi umur Anda di profil terlebih dahulu.'
                ], 400);
            }

            // 🔍 CEK APAKAH ADA PEMERIKSAAN YANG BELUM SELESAI?
            // (Cek yang hasil_diagnosa-nya masih NULL milik user ini)
            $existingPemeriksaan = Pemeriksaan::where('id_user', $user->id)
                ->whereNull('hasil_diagnosa') // Asumsi kolom ini NULL jika belum diagnosa
                ->latest()
                ->first();

            if ($existingPemeriksaan) {
                // Kalau ada yang gantung, pakai ID itu lagi (JANGAN BUAT BARU)
                Log::info('Resuming pemeriksaan', ['id' => $existingPemeriksaan->id]);
                
                return response()->json([
                    'success' => true,
                    'id_pemeriksaan' => $existingPemeriksaan->id,
                    'message' => 'Melanjutkan pemeriksaan sebelumnya...',
                    'user_info' => [
                        'nama' => $user->name,
                        'umur' => $user->umur
                    ]
                ]);
            }

            // Kalau tidak ada yang gantung, baru buat BARU
            $pemeriksaan = Pemeriksaan::create([
                'id_user' => $user->id,
                'tanggal' => now(),
                'persentase_cf' => 0,
                'hasil_diagnosa' => null // Pastikan defaultnya null
            ]);

            Log::info('Pemeriksaan created', [
                'id' => $pemeriksaan->id,
                'user' => $user->name
            ]);

            return response()->json([
                'success' => true,
                'id_pemeriksaan' => $pemeriksaan->id,
                'message' => 'Pemeriksaan berhasil dibuat!',
                'user_info' => [
                    'nama' => $user->name,
                    'umur' => $user->umur
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Create pemeriksaan failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pemeriksaan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 📝 Get pertanyaan berdasarkan kategori
     */
    public function getPertanyaan(Request $request)
    {
        $kategori = (int) $request->get('kategori', 1);

        try {
            if ($kategori === 1) {
                // ✅ SCREENING: Pertanyaan inklusi/eksklusi
                $pertanyaan = $this->getPertanyaanScreening();
                
                $data = [];
                
                // Pertanyaan Inklusi
                foreach ($pertanyaan['inklusi'] as $id => $text) {
                    $data[] = [
                        'id' => 'inklusi_' . $id,
                        'question' => $text,
                        'type' => 'inklusi',
                        'options' => ['Ya', 'Tidak']
                    ];
                }
                
                // Pertanyaan Eksklusi
                foreach ($pertanyaan['eksklusi'] as $id => $text) {
                    $data[] = [
                        'id' => 'eksklusi_' . $id,
                        'question' => $text,
                        'type' => 'eksklusi',
                        'options' => ['Ya', 'Tidak']
                    ];
                }

            } else {
                // ✅ GEJALA: Pertanyaan berdasarkan kategori
                $rangeMap = [
                    2 => ['G00', 'G03'], // Mata Lelah
                    3 => ['G04', 'G07'], // Mata Kering
                    4 => ['G08', 'G11'], // Mata Kabur
                    5 => ['G12', 'G15'], // Mata Gatal
                    6 => ['G16', 'G19'], // Mata Berair
                    7 => ['G20', 'G23'], // Mata Sensitif
                ];

                $range = $rangeMap[$kategori] ?? ['G00', 'G03'];

                $gejalaList = Gejala::whereBetween('kode_gejala', $range)
                    ->orderBy('kode_gejala')
                    ->get();

                $data = [];
                foreach ($gejalaList as $gejala) {
                    $data[] = [
                        'id' => $gejala->id,
                        'kode' => $gejala->kode_gejala,
                        'question' => $gejala->deskripsi,
                        'type' => 'gejala',
                        'cf_pakar' => $gejala->bobot,
                        'options' => [
                            ['text' => 'Tidak Pernah', 'nilai' => 0.0],
                            ['text' => 'Kadang-kadang', 'nilai' => 0.4],
                            ['text' => 'Cukup Sering', 'nilai' => 0.6],
                            ['text' => 'Selalu', 'nilai' => 0.8],
                        ]
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'kategori' => $kategori,
                'data' => $data,
                'total' => count($data)
            ]);

        } catch (\Exception $e) {
            Log::error('Get pertanyaan failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil pertanyaan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 💾 Simpan jawaban screening (inklusi/eksklusi)
     */
    public function simpanScreening(Request $request)
    {
        Log::info("=== SIMPAN SCREENING ===");

        $validated = $request->validate([
            'id_pemeriksaan' => 'required|exists:pemeriksaan,id',
            'jawaban' => 'required|array|size:7', // 5 inklusi + 2 eksklusi
        ]);

        try {
            $idPemeriksaan = $validated['id_pemeriksaan'];
            
            $pemeriksaan = Pemeriksaan::where('id', $idPemeriksaan)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            $jawaban = $validated['jawaban'];

            // Pisahkan jawaban inklusi dan eksklusi
            $jawabanInklusi = [];
            $jawabanEksklusi = [];

            foreach ($jawaban as $key => $value) {
                if (strpos($key, 'inklusi_') === 0) {
                    $jawabanInklusi[] = $value;
                } elseif (strpos($key, 'eksklusi_') === 0) {
                    $jawabanEksklusi[] = $value;
                }
            }

            // Hitung hasil screening
            $semuaInklusiYa = count(array_filter($jawabanInklusi, fn($v) => $v === 'Ya')) === 5;
            $adaEksklusiYa = count(array_filter($jawabanEksklusi, fn($v) => $v === 'Ya')) > 0;

            // Simpan hasil screening
            InklusiEksklusi::create([
                'id_pemeriksaan' => $idPemeriksaan,
                'memenuhi_inklusi' => $semuaInklusiYa,
                'ada_eksklusi' => $adaEksklusiYa,
            ]);

            $lolos = $semuaInklusiYa && !$adaEksklusiYa;

            Log::info("Screening result", [
                'inklusi' => $semuaInklusiYa,
                'eksklusi' => $adaEksklusiYa,
                'lolos' => $lolos
            ]);

            return response()->json([
                'success' => true,
                'lolos' => $lolos,
                'message' => $lolos 
                    ? 'Anda memenuhi kriteria untuk diagnosis CVS.' 
                    : 'Anda tidak memenuhi kriteria untuk diagnosis CVS.',
            ]);

        } catch (\Exception $e) {
            Log::error('Simpan screening failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan screening: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 💾 Simpan jawaban gejala per kategori
     */
    public function simpanJawaban(Request $request)
    {
        Log::info("=== SIMPAN JAWABAN GEJALA ===", [
            'id_pemeriksaan' => $request->id_pemeriksaan,
            'jawaban_count' => count($request->jawaban ?? [])
        ]);

        $validated = $request->validate([
            'id_pemeriksaan' => 'required|exists:pemeriksaan,id',
            'jawaban' => 'required|array',
            'jawaban.*.id' => 'required|exists:gejala,id',
            'jawaban.*.answer' => 'required',
            'jawaban.*.nilai' => 'required|numeric',
        ]);

        try {
            $idPemeriksaan = $validated['id_pemeriksaan'];
            
            $pemeriksaan = Pemeriksaan::where('id', $idPemeriksaan)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            $jawabanList = $validated['jawaban'];
            $savedCount = 0;

            DB::beginTransaction();

            foreach ($jawabanList as $item) {
                $gejala = Gejala::find($item['id']);
                
                if ($gejala) {
                    $cfPakar = $gejala->bobot;
                    $cfUser = $item['nilai'];
                    $cfGabungan = $cfPakar * $cfUser;

                    Jawaban::updateOrCreate(
                        [
                            'id_pemeriksaan' => $idPemeriksaan,
                            'id_gejala' => $item['id'],
                        ],
                        [
                            'jawaban_text' => $item['answer'],
                            'nilai_cf' => $cfGabungan,
                        ]
                    );
                    $savedCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menyimpan {$savedCount} jawaban gejala!",
                'saved_count' => $savedCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Save jawaban failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan jawaban: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🧮 Hitung diagnosis final
     */
    public function hitungDiagnosis(Request $request)
    {
        Log::info("=== HITUNG DIAGNOSIS ===");

        $validated = $request->validate([
            'id_pemeriksaan' => 'required|exists:pemeriksaan,id',
        ]);

        try {
            $idPemeriksaan = $validated['id_pemeriksaan'];
            
            $pemeriksaan = Pemeriksaan::where('id', $idPemeriksaan)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            // Ambil semua jawaban gejala yang sudah disimpan
            $jawabanGejala = Jawaban::where('id_pemeriksaan', $idPemeriksaan)
                ->whereNotNull('id_gejala')
                ->where('nilai_cf', '>', 0)
                ->pluck('nilai_cf')
                ->toArray();

            // Hitung CF Combine (Algoritma Tidak Diubah)
            if (empty($jawabanGejala)) {
                $persentase = 0.0;
            } else {
                rsort($jawabanGejala); // Sort descending
                $cfCombine = $jawabanGejala[0];

                for ($i = 1; $i < count($jawabanGejala); $i++) {
                    $cfOld = $cfCombine;
                    $cfNew = $jawabanGejala[$i];
                    $cfCombine = $cfOld + ($cfNew * (1 - $cfOld));
                }

                $persentase = round($cfCombine * 100, 2);
            }

            $diagnosis = $this->getDiagnosisLevel($persentase);

            // Update pemeriksaan
            $pemeriksaan->update([
                'persentase_cf' => $persentase,
                'hasil_diagnosa' => $diagnosis['level'],
            ]);

            DB::commit();

            // ✅ PERBAIKAN: Menambahkan 'redirect_url' agar JS tahu kemana harus pindah
            return response()->json([
                'success' => true,
                'id_pemeriksaan' => $idPemeriksaan,
                'persentase' => $persentase,
                'diagnosis' => $diagnosis,
                'redirect_url' => route('hasil.show', $idPemeriksaan) // INI KUNCINYA
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Hitung diagnosis failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung diagnosis: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 📊 Tampilkan hasil diagnosis
     */
    public function hasilDiagnosis($idPemeriksaan)
    {
        try {
            $pemeriksaan = Pemeriksaan::with(['user', 'jawaban.gejala'])
                ->where('id', $idPemeriksaan)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            $diagnosis = $this->getDiagnosisLevel($pemeriksaan->persentase_cf);

            $jawabanGejala = Jawaban::where('id_pemeriksaan', $idPemeriksaan)
                ->whereNotNull('id_gejala')
                ->where('nilai_cf', '>', 0)
                ->with('gejala')
                ->orderBy('nilai_cf', 'desc')
                ->get();

            // ✅ PERBAIKAN: Menggunakan nama view yang benar 'hasilpemeriksaan'
            return view('hasilpemeriksaan', compact('pemeriksaan', 'diagnosis', 'jawabanGejala'));

        } catch (\Exception $e) {
            Log::error('Show hasil failed: ' . $e->getMessage());
            return redirect()->route('pertanyaan')->with('error', 'Pemeriksaan tidak ditemukan');
        }
    }

    /**
     * 📜 Get riwayat pemeriksaan
     */
    public function getRiwayat()
    {
        try {
            $riwayat = Pemeriksaan::where('id_user', Auth::id())
                ->with('user')
                ->orderBy('tanggal', 'desc')
                ->get()
                ->map(function($p) {
                    return [
                        'id_pemeriksaan' => $p->id,
                        'nama_pasien' => $p->user->name,
                        'usia' => $p->user->umur,
                        'tanggal' => $p->tanggal->format('d/m/Y H:i'),
                        'persentase' => $p->persentase_cf,
                        'diagnosis' => $this->getDiagnosisLevel($p->persentase_cf)['level'],
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $riwayat
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🎯 Helper: Get diagnosis level
     */
    private function getDiagnosisLevel($persentase)
    {
        if ($persentase >= 80) {
            return [
                'level' => 'Sangat Berat',
                'color' => 'red',
                'keterangan' => 'Gejala CVS sangat parah, segera konsultasi dokter mata',
                'rekomendasi' => 'Kurangi penggunaan layar drastis, istirahat total, segera konsultasi dokter spesialis mata untuk penanganan lebih lanjut.'
            ];
        } elseif ($persentase >= 60) {
            return [
                'level' => 'Berat',
                'color' => 'orange',
                'keterangan' => 'Gejala CVS berat, perlu penanganan serius',
                'rekomendasi' => 'Batasi screen time, gunakan kacamata anti radiasi, terapkan aturan 20-20-20, gunakan eye drops, dan istirahat yang cukup.'
            ];
        } elseif ($persentase >= 40) {
            return [
                'level' => 'Sedang',
                'color' => 'yellow',
                'keterangan' => 'Gejala CVS sedang, perlu perhatian khusus',
                'rekomendasi' => 'Terapkan aturan 20-20-20 secara konsisten, atur pencahayaan ruangan, gunakan artificial tears, dan pastikan jarak layar minimal 50cm.'
            ];
        } elseif ($persentase >= 20) {
            return [
                'level' => 'Ringan',
                'color' => 'blue',
                'keterangan' => 'Gejala CVS ringan, mulai terapkan pencegahan',
                'rekomendasi' => 'Istirahat mata secara berkala, atur posisi layar sejajar mata, jaga pencahayaan yang baik, dan lakukan peregangan mata.'
            ];
        } else {
            return [
                'level' => 'Normal',
                'color' => 'green',
                'keterangan' => 'Tidak terindikasi CVS, kondisi mata baik',
                'rekomendasi' => 'Pertahankan kebiasaan baik saat menggunakan layar, tetap waspada terhadap gejala awal CVS.'
            ];
        }
    }
}