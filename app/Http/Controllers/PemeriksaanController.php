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
                $validJawaban = array_filter($jawabanBaru, function($item) {
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

            // ============================================
            // TAHAP 2: HITUNG DIAGNOSA (CRITICAL FIX!)
            // ============================================
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
                        $i, $cfOld, $cfNew, $cfOld, $cfCombine
                    ));
                }

                // Konversi ke persentase
                $persentase = round($cfCombine * 100, 2);
                Log::info("Final Persentase: {$persentase}%");
            } else {
                Log::warning("No CF values found! Persentase will be 0");
            }

            // ============================================
            // TAHAP 3: DETERMINE DIAGNOSIS LEVEL
            // ============================================
            $diagnosisData = $this->getDiagnosisLevel($persentase);
            Log::info("Diagnosis determined:", $diagnosisData);

            // ============================================
            // TAHAP 4: UPDATE PEMERIKSAAN
            // ============================================
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
        
        if ($persentase >= 80) {
            return [
                'level' => 'Sangat Berat',
                'color' => 'red',
                'keterangan' => 'Segera ke dokter mata.',
                'rekomendasi' => 'Istirahat total dari layar, konsultasi medis segera.'
            ];
        }
        
        if ($persentase >= 60) {
            return [
                'level' => 'Berat',
                'color' => 'orange',
                'keterangan' => 'Gejala serius.',
                'rekomendasi' => 'Batasi layar maksimal, pakai kacamata anti-radiasi.'
            ];
        }
        
        if ($persentase >= 40) {
            return [
                'level' => 'Sedang',
                'color' => 'yellow',
                'keterangan' => 'Perlu perhatian.',
                'rekomendasi' => 'Terapkan 20-20-20 rule, atur pencahayaan.'
            ];
        }
        
        if ($persentase >= 20) {
            return [
                'level' => 'Ringan',
                'color' => 'blue',
                'keterangan' => 'Gejala awal.',
                'rekomendasi' => 'Istirahat berkala, kedipkan mata lebih sering.'
            ];
        }
        
        return [
            'level' => 'Normal',
            'color' => 'green',
            'keterangan' => 'Mata sehat.',
            'rekomendasi' => 'Pertahankan kebiasaan baik.'
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
                6 => 'Apakah Anda memiliki riwayat kelainan refraksi berat atau sering berganti kacamata?',
                7 => 'Apakah Anda memiliki kelainan anatomi pada bola mata (misalnya bentuk kornea abnormal)?',
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

                foreach ($pertanyaan['inklusi'] as $id => $text) {
                    $data[] = [
                        'id' => 'inklusi_' . $id,
                        'question' => $text,
                        'type' => 'inklusi',
                        'options' => ['Ya', 'Tidak']
                    ];
                }
                
                foreach ($pertanyaan['eksklusi'] as $id => $text) {
                    $data[] = [
                        'id' => 'eksklusi_' . $id,
                        'question' => $text,
                        'type' => 'eksklusi',
                        'options' => ['Ya', 'Tidak']
                    ];
                }
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
    $validated = $request->validate([
        'id_pemeriksaan' => 'required|exists:pemeriksaan,id',
        'jawaban' => 'required|array', // ❌ Ini harusnya object/map, bukan array
    ]);

    try {
        $inclCount = 0;
        $exclCount = 0;

        // ✅ FIX: Loop as object/map
        foreach ($validated['jawaban'] as $key => $val) {
            if (str_starts_with($key, 'inklusi_') && $val === 'Ya')
                $inclCount++;

            if (str_starts_with($key, 'eksklusi_') && $val === 'Ya')
                $exclCount++;
        }

        $lolos = ($inclCount === 5) && ($exclCount === 0);

        InklusiEksklusi::updateOrCreate(
            ['id_pemeriksaan' => $validated['id_pemeriksaan']],
            [
                'memenuhi_inklusi' => ($inclCount === 5),
                'ada_eksklusi' => ($exclCount > 0)
            ]
        );

        return response()->json([
            'success' => true,
            'lolos' => $lolos,
            'message' => $lolos ? 'Lolos screening' : 'Tidak lolos screening'
        ]);

    } catch (\Exception $e) {
        Log::error('Simpan Screening Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function hasilDiagnosis($idPemeriksaan)
    {
        try {
            $pemeriksaan = Pemeriksaan::with('user')->findOrFail($idPemeriksaan);

            if ($pemeriksaan->id_user !== Auth::id()) {
                abort(403);
            }

            $diagnosis = $this->getDiagnosisLevel($pemeriksaan->persentase_cf);

            $jawabanGejala = Jawaban::with('gejala')
                ->where('id_pemeriksaan', $idPemeriksaan)
                ->where('nilai_cf', '>', 0)
                ->orderByDesc('nilai_cf')
                ->get();

            return view('hasilpemeriksaan', compact('pemeriksaan', 'diagnosis', 'jawabanGejala'));

        } catch (\Exception $e) {
            Log::error('Hasil Diagnosis Error: ' . $e->getMessage());
            return redirect()->route('pertanyaan')->with('error', 'Data tidak ditemukan');
        }
    }
}