<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Jawaban;
use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class PemeriksaanController extends Controller
{
    public function showForm()
    {
        $gejala = Gejala::all();
        return view('pemeriksaan.form', compact('gejala'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id() ?? 1; 

        $pemeriksaan = Pemeriksaan::create([
            'id_user' => $userId,
            'tanggal' => now(),
        ]);

        $totalBobot = 0;
        $gejalaCount = count($request->gejala ?? []);

        foreach ($request->gejala ?? [] as $gejalaId => $nilai) {
            $gejala = Gejala::find($gejalaId);
            $bobot = $gejala->bobot * ($nilai ? 1 : 0);
            Jawaban::create([
                'id_periksa' => $pemeriksaan->id_periksa,
                'id_gejala' => $gejalaId,
                'nilai_jawaban' => $bobot,
            ]);
            $totalBobot += $bobot;
        }

        $persentase = ($gejalaCount > 0) ? ($totalBobot / $gejalaCount) * 100 : 0;

        $pemeriksaan->update([
            'persentase_cf' => $persentase,
        ]);

        $diagnosisText = $persentase >= 50 ? 'Berat' : ($persentase >= 20 ? 'Ringan' : 'Normal');
        return redirect()->route('hasil')->with('persentase', $persentase)->with('diagnosis', $diagnosisText);
    }
}
