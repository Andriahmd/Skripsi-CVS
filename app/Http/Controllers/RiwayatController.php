<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RiwayatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman riwayat pemeriksaan user
     */
    public function index()
    {
        try {
            // Ambil semua pemeriksaan user yang sudah selesai (punya hasil diagnosa)
            $riwayatPemeriksaan = Pemeriksaan::where('id_user', Auth::id())
                ->whereNotNull('hasil_diagnosa')
                ->orderBy('tanggal', 'desc')
                ->paginate(10);

            Log::info('Riwayat loaded for user ' . Auth::id() . ': ' . $riwayatPemeriksaan->count() . ' records');

            // ✅ UBAH NAMA VIEW SESUAI FILE ANDA
            return view('riwayat', compact('riwayatPemeriksaan'));

        } catch (\Exception $e) {
            Log::error('Riwayat Index Error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Gagal memuat riwayat pemeriksaan.');
        }
    }

    /**
     * Tampilkan detail pemeriksaan tertentu
     */
    public function show($id)
    {
        try {
            $pemeriksaan = Pemeriksaan::with('user', 'jawaban.gejala')
                ->where('id', $id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            // Redirect ke halaman hasil yang sudah ada
            return redirect()->route('hasil.show', $id);

        } catch (\Exception $e) {
            Log::error('Riwayat Show Error: ' . $e->getMessage());
            return redirect()->route('riwayat.index')->with('error', 'Data pemeriksaan tidak ditemukan.');
        }
    }

    /**
     * Hapus pemeriksaan (opsional)
     */
    public function destroy($id)
    {
        try {
            $pemeriksaan = Pemeriksaan::where('id', $id)
                ->where('id_user', Auth::id())
                ->firstOrFail();

            $pemeriksaan->delete();

            Log::info("Pemeriksaan ID {$id} deleted by user " . Auth::id());

            return redirect()->route('riwayat.index')->with('success', 'Riwayat pemeriksaan berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Riwayat Delete Error: ' . $e->getMessage());
            return redirect()->route('riwayat.index')->with('error', 'Gagal menghapus riwayat.');
        }
    }

    /**
     * Helper untuk mendapatkan warna badge berdasarkan diagnosa
     */
    private function getDiagnosisColor($diagnosa)
    {
        switch ($diagnosa) {
            case 'Berat':
                return 'red';
            case 'Sedang':
                return 'orange';
            case 'Ringan':
                return 'yellow';
            default:
                return 'green';
        }
    }
}