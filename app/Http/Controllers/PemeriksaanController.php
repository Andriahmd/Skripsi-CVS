<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Jawaban;
use App\Models\Gejala;
use App\Models\Saran;
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

    // ==========================================
    // SUBMIT TOTAL - FIXED VERSION v2 🔥🔥
    // ==========================================
    public function submitTotal(Request $request)
    {
        Log::info('=== SUBMIT TOTAL START ===');
        Log::info('Raw Request:', $request->all());

        try {
            $validated = $request->validate([
                'id_pemeriksaan' => 'required|exists:pemeriksaan,id',
                'jawaban' => 'nullable|array'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi Error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . json_encode($e->errors())
            ], 422);
        }

        $idPemeriksaan = $validated['id_pemeriksaan'];
        $jawabanBaru = $validated['jawaban'] ?? [];

        Log::info("Processing ID: {$idPemeriksaan}, Jawaban Count: " . count($jawabanBaru));

        try {
            DB::beginTransaction();

            // ============================================
            // TAHAP 1: SIMPAN JAWABAN
            // ============================================
            $jumlahTersimpan = 0;

            if (!empty($jawabanBaru)) {
                // Filter jawaban valid
                $validJawaban = array_filter($jawabanBaru, function ($item) {
                    $valid = isset($item['id']) &&
                        isset($item['answer']) &&
                        isset($item['nilai']) &&
                        is_numeric($item['id']) &&
                        is_numeric($item['nilai']);

                    if (!$valid) {
                        Log::warning('Invalid jawaban item:', $item);
                    }
                    return $valid;
                });

                Log::info("Valid jawaban: " . count($validJawaban));

                if (!empty($validJawaban)) {
                    $gejalaIds = array_map(fn($item) => (int) $item['id'], $validJawaban);

                    // Hapus jawaban lama
                    $deleted = Jawaban::where('id_pemeriksaan', $idPemeriksaan)
                        ->whereIn('id_gejala', $gejalaIds)
                        ->delete();

                    Log::info("Deleted old answers: {$deleted}");

                    // Ambil master gejala
                    $masterGejala = Gejala::whereIn('id', $gejalaIds)->get()->keyBy('id');
                    Log::info("Master gejala found: " . $masterGejala->count());

                    $dataInsert = [];
                    $now = now();

                    foreach ($validJawaban as $item) {
                        $gejalaId = (int) $item['id'];

                        if (!isset($masterGejala[$gejalaId])) {
                            Log::warning("Gejala {$gejalaId} not found in master");
                            continue;
                        }

                        $bobotPakar = (float) $masterGejala[$gejalaId]->bobot;
                        $cfUser = (float) $item['nilai'];
                        $nilaiCF = $bobotPakar * $cfUser;

                        Log::info("Gejala {$gejalaId}: Pakar={$bobotPakar}, User={$cfUser}, CF={$nilaiCF}");

                        $dataInsert[] = [
                            'id_pemeriksaan' => $idPemeriksaan,
                            'id_gejala' => $gejalaId,
                            'jawaban_text' => $item['answer'],
                            'nilai_cf' => $nilaiCF,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }

                    if (!empty($dataInsert)) {
                        Jawaban::insert($dataInsert);
                        $jumlahTersimpan = count($dataInsert);
                        Log::info("✅ Inserted {$jumlahTersimpan} answers");
                    }
                }
            }


            Log::info('=== CALCULATING CF COMBINE ===');

            // Ambil SEMUA jawaban dengan CF > 0
            $allAnswers = Jawaban::where('id_pemeriksaan', $idPemeriksaan)
                ->where('nilai_cf', '>', 0)
                ->get(['id_gejala', 'nilai_cf']);

            Log::info("Total answers with CF > 0: " . $allAnswers->count());
            Log::info("CF Values:", $allAnswers->pluck('nilai_cf')->toArray());

            $persentase = 0;
            $cfCombine = 0;

            if ($allAnswers->count() > 0) {
                // Ambil array CF values dan sort descending
                $cfValues = $allAnswers->pluck('nilai_cf')->toArray();
                rsort($cfValues);

                Log::info("Sorted CF Values:", $cfValues);

                // Inisialisasi dengan nilai pertama
                $cfCombine = $cfValues[0];
                Log::info("Initial CF: {$cfCombine}");

                // CF Combine untuk nilai kedua dan seterusnya
                for ($i = 1; $i < count($cfValues); $i++) {
                    $cfOld = $cfCombine;
                    $cfNew = $cfValues[$i];
                    $cfCombine = $cfOld + ($cfNew * (1 - $cfOld));

                    Log::info(sprintf(
                        "Step %d: %.4f + (%.4f * (1 - %.4f)) = %.4f",
                        $i,
                        $cfOld,
                        $cfNew,
                        $cfOld,
                        $cfCombine
                    ));
                }

                // Konversi ke persentase
                $persentase = round($cfCombine * 100, 2);
                Log::info("Final Persentase: {$persentase}%");
            } else {
                Log::warning("No CF values found! Persentase will be 0");
            }


            $diagnosisData = $this->getDiagnosisLevel($persentase);
            Log::info("Diagnosis determined:", $diagnosisData);


            $updateData = [
                'persentase_cf' => $persentase,
                'hasil_diagnosa' => $diagnosisData['level']
            ];

            Log::info("Updating pemeriksaan with:", $updateData);

            $updated = Pemeriksaan::where('id', $idPemeriksaan)->update($updateData);

            if ($updated) {
                Log::info("✅ Pemeriksaan updated successfully");
            } else {
                Log::warning("⚠️ Pemeriksaan update returned 0 (might already have same values)");
            }

            // Verify update
            $verification = Pemeriksaan::find($idPemeriksaan);
            Log::info("Verification - Persentase: {$verification->persentase_cf}, Diagnosa: {$verification->hasil_diagnosa}");

            DB::commit();
            Log::info('=== TRANSACTION COMMITTED ===');

            return response()->json([
                'success' => true,
                'redirect_url' => route('hasil.show', $idPemeriksaan),
                'debug' => [
                    'id_pemeriksaan' => $idPemeriksaan,
                    'jawaban_tersimpan' => $jumlahTersimpan,
                    'total_cf_values' => $allAnswers->count(),
                    'cf_combine' => round($cfCombine, 4),
                    'persentase' => $persentase,
                    'diagnosis_level' => $diagnosisData['level']
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('=== EXCEPTION IN SUBMIT TOTAL ===');
            Log::error('Message: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            Log::error('Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error processing data',
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    // ==========================================
    // FUNGSI PENDUKUNG
    // ==========================================

    private function getDiagnosisLevel($persentase)
    {
        Log::info("Getting diagnosis level for: {$persentase}%");

        if ($persentase >= 75) {
            return [
                'level' => 'Berat',
                'color' => 'red',
            ];
        }

        if ($persentase >= 50) {
            return [
                'level' => 'Sedang',
                'color' => 'orange',
            ];
        }

        if ($persentase >= 25) {
            return [
                'level' => 'Ringan',
                'color' => 'yellow',
            ];
        }

        return [
            'level' => 'Tidak Mengalami',
            'color' => 'green',
        ];
    }

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
                1 => 'Apakah Anda memiliki riwayat kelainan refraksi berat atau sering berganti kacamata?',
                2 => 'Apakah Anda memiliki kelainan anatomi pada bola mata (misalnya bentuk kornea abnormal)?',
                3 => 'Apakah Anda memiliki riwayat mata merah, infeksi, atau peradangan pada mata baru-baru ini?',
                4 => 'Apakah Anda memiliki riwayat tekanan bola mata tinggi (glaukoma)?',
                5 => 'Apakah Anda memiliki riwayat ambliopia (mata malas)?',
                6 => 'Apakah Anda pernah didiagnosis mengalami sindrom mata kering yang tidak terkait dengan penggunaan layar?',
                7 => 'Apakah Anda saat ini sedang dalam pengobatan atau pernah rutin menggunakan obat-obatan tertentu yang memengaruhi kondisi mata?',
            ],
        ];
    }

    public function showForm()
    {
        return view('pertanyaan');
    }

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

            $pemeriksaan = Pemeriksaan::create([
                'id_user' => $user->id,
                'tanggal' => now(),
                'persentase_cf' => 0,
                'hasil_diagnosa' => null
            ]);

            return response()->json([
                'success' => true,
                'id_pemeriksaan' => $pemeriksaan->id,
                'message' => 'Pemeriksaan berhasil dibuat!',
            ]);
        } catch (\Exception $e) {
            Log::error('Create error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server Error'], 500);
        }
    }

    public function getPertanyaan(Request $request)
    {
        $kategori = (int) $request->get('kategori', 1);

        try {
            if ($kategori === 1) {
                $pertanyaan = $this->getPertanyaanScreening();
                $data = [];

                // Inklusi (5 pertanyaan)
                foreach ($pertanyaan['inklusi'] as $id => $text) {
                    $data[] = [
                        'id' => 'inklusi_' . $id,
                        'question' => $text,
                        'type' => 'inklusi',
                        'options' => ['Ya', 'Tidak']
                    ];
                }

                // Eksklusi (7 pertanyaan - UPDATED)
                foreach ($pertanyaan['eksklusi'] as $id => $text) {
                    $data[] = [
                        'id' => 'eksklusi_' . $id,
                        'question' => $text,
                        'type' => 'eksklusi',
                        'options' => ['Ya', 'Tidak']
                    ];
                }

                Log::info("Screening questions loaded: " . count($data) . " total (5 inklusi + 7 eksklusi)");

            } else {
                $rangeMap = [
                    2 => ['G00', 'G03'],
                    3 => ['G04', 'G07'],
                    4 => ['G08', 'G11'],
                    5 => ['G12', 'G15'],
                    6 => ['G16', 'G19'],
                    7 => ['G20', 'G23'],
                ];

                $range = $rangeMap[$kategori] ?? ['G00', 'G03'];

                $gejalaList = Gejala::whereBetween('kode_gejala', $range)
                    ->orderBy('kode_gejala')
                    ->get(['id', 'kode_gejala', 'deskripsi', 'bobot']);

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

            return response()->json(['success' => true, 'data' => $data]);

        } catch (\Exception $e) {
            Log::error('Get Pertanyaan Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal load data'], 500);
        }
    }

   public function simpanScreening(Request $request)
    {
        Log::info('=== SCREENING START (FIXED) ===');
        Log::info('Request data:', $request->all());

        $validated = $request->validate([
            'id_pemeriksaan' => 'required|exists:pemeriksaan,id',
            'jawaban' => 'required|array',
        ]);

        try {
            $jawaban = $validated['jawaban'];

            // Hitung jawaban inklusi dan eksklusi
            $inklusiYa = 0;
            $inklusiTidak = 0;
            $eksklusiYa = 0;
            $eksklusiTidak = 0;

            // ✅ Array nilai yang dianggap "YA" (Case Insensitive)
            $validYes = ['ya', 'yes', '1', 'true'];

            foreach ($jawaban as $key => $val) {
                // Konversi jawaban ke lowercase string biar aman
                $cleanVal = strtolower((string)$val); 
                $isYes = in_array($cleanVal, $validYes);

                if (str_starts_with($key, 'inklusi_')) {
                    if ($isYes) {
                        $inklusiYa++;
                    } else {
                        $inklusiTidak++;
                    }
                }

                if (str_starts_with($key, 'eksklusi_')) {
                    if ($isYes) {
                        $eksklusiYa++;
                    } else {
                        $eksklusiTidak++;
                    }
                }
            }

            $totalInklusi = $inklusiYa + $inklusiTidak;
            $totalEksklusi = $eksklusiYa + $eksklusiTidak;

            Log::info("Inklusi: Ya={$inklusiYa}, Tidak={$inklusiTidak}, Total={$totalInklusi}/5");
            Log::info("Eksklusi: Ya={$eksklusiYa}, Tidak={$eksklusiTidak}, Total={$totalEksklusi}/7");

            // Cek kelengkapan
            // Pastikan jumlah pertanyaan sesuai dengan frontend (5 inklusi + 7 eksklusi = 12 total)
            $isComplete = ($totalInklusi === 5 && $totalEksklusi === 7);

            Log::info("Is Complete: " . ($isComplete ? 'YES' : 'NO'));

            // Simpan status sementara ke DB
            InklusiEksklusi::updateOrCreate(
                ['id_pemeriksaan' => $validated['id_pemeriksaan']],
                [
                    'memenuhi_inklusi' => ($inklusiYa === 5),
                    'ada_eksklusi' => ($eksklusiYa > 0)
                ]
            );

            // Validasi kelolosan HANYA jika semua pertanyaan sudah dijawab
            if ($isComplete) {
                $memenuhiInklusi = ($inklusiYa === 5); // Harus 5 "Ya"
                $tidakAdaEksklusi = ($eksklusiYa === 0); // Harus 0 "Ya" (semua "Tidak")
                
                $lolos = $memenuhiInklusi && $tidakAdaEksklusi;

                Log::info("RESULT -> Memenuhi Inklusi: " . ($memenuhiInklusi ? 'YA' : 'TIDAK'));
                Log::info("RESULT -> Tidak Ada Eksklusi: " . ($tidakAdaEksklusi ? 'YA' : 'TIDAK'));
                Log::info("FINAL RESULT: " . ($lolos ? 'LOLOS' : 'GAGAL'));

                if (!$lolos) {
                    // Jika GAGAL, hapus data pemeriksaan agar user harus mengulang
                    DB::beginTransaction();
                    try {
                        Pemeriksaan::where('id', $validated['id_pemeriksaan'])->delete();
                        DB::commit();
                        Log::warning("⚠️ Pemeriksaan deleted - Gagal Screening");

                        // Pesan Error Detail
                        $message = "Maaf, Anda tidak memenuhi syarat screening.\n\n";
                        
                        if (!$memenuhiInklusi) {
                            $message .= "- Kriteria Inklusi Belum Terpenuhi: Anda menjawab 'Tidak' pada " . (5 - $inklusiYa) . " pertanyaan wajib.\n";
                        }
                        
                        if (!$tidakAdaEksklusi) {
                            $message .= "- Kriteria Eksklusi Terdeteksi: Anda menjawab 'Ya' pada " . $eksklusiYa . " kondisi yang dilarang/eksklusi.\n";
                        }

                        $message .= "\nSilakan konsultasi dengan dokter.";

                        return response()->json([
                            'success' => false,
                            'lolos' => false,
                            'complete' => true,
                            'message' => $message,
                            'detail' => [
                                'inklusi_ya' => $inklusiYa,
                                'eksklusi_ya' => $eksklusiYa
                            ]
                        ]);

                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error("Error deleting pemeriksaan: " . $e->getMessage());
                    }
                }

                // Jika LOLOS
                return response()->json([
                    'success' => true,
                    'lolos' => true,
                    'complete' => true,
                    'message' => 'Selamat! Anda lolos screening.',
                ]);
            }

            // Jika belum lengkap (masih proses menjawab)
            return response()->json([
                'success' => true,
                'lolos' => null,
                'complete' => false,
                'message' => 'Jawaban tersimpan sementara',
            ]);

        } catch (\Exception $e) {
            Log::error('Simpan Screening Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }


    public function hasilDiagnosis($idPemeriksaan)
    {
        try {
            Log::info("Displaying hasil for pemeriksaan ID: {$idPemeriksaan}");

            // Ambil data pemeriksaan dengan relasi user
            $pemeriksaan = Pemeriksaan::with('user')->findOrFail($idPemeriksaan);

            // Cek authorization
            if ($pemeriksaan->id_user !== Auth::id()) {
                Log::warning("Unauthorized access attempt by user " . Auth::id());
                abort(403, 'Anda tidak memiliki akses ke hasil pemeriksaan ini.');
            }

            Log::info("Pemeriksaan found - Persentase: {$pemeriksaan->persentase_cf}%, Diagnosa: {$pemeriksaan->hasil_diagnosa}");

            // Get diagnosis level (warna badge)
            $diagnosis = $this->getDiagnosisLevel($pemeriksaan->persentase_cf);

            Log::info("Diagnosis level determined: " . $diagnosis['level']);

            // ✅ AMBIL SARAN DARI DATABASE BERDASARKAN PERSENTASE
            $saran = Saran::where('persentase_min', '<=', $pemeriksaan->persentase_cf)
                ->where('persentase_max', '>=', $pemeriksaan->persentase_cf)
                ->first();

            if ($saran) {
                Log::info("Saran found: {$saran->kategori} (ID: {$saran->id_saran})");
            } else {
                Log::warning("⚠️ No saran found for persentase {$pemeriksaan->persentase_cf}%");
            }

            // Ambil jawaban gejala dengan CF > 0
            $jawabanGejala = Jawaban::with('gejala')
                ->where('id_pemeriksaan', $idPemeriksaan)
                ->where('nilai_cf', '>', 0)
                ->orderByDesc('nilai_cf')
                ->get();

            Log::info("Jawaban gejala count: " . $jawabanGejala->count());

            // ✅ KIRIM VARIABEL $saran KE VIEW
            return view('hasilpemeriksaan', compact('pemeriksaan', 'diagnosis', 'jawabanGejala', 'saran'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Pemeriksaan not found: {$idPemeriksaan}");
            return redirect()->route('pertanyaan')->with('error', 'Data pemeriksaan tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error('Hasil Diagnosis Error: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            Log::error($e->getTraceAsString());

            return redirect()->route('pertanyaan')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}