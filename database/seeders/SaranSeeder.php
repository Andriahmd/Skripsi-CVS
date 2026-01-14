<?php
// database/seeders/SaranSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Saran;

class SaranSeeder extends Seeder
{
    public function run(): void
    {
        $saranData = [
            [
                'kategori' => 'Tidak Mengalami',
                'persentase_min' => 0.00,
                'persentase_max' => 24.99,
                'isi_saran' => 'Selamat! Mata Anda dalam kondisi sehat dan tidak menunjukkan gejala Computer Vision Syndrome (CVS). Pertahankan kebiasaan baik dalam menggunakan perangkat digital seperti mengatur jarak pandang, pencahayaan yang baik, dan istirahat berkala. Tetap lakukan pemeriksaan mata rutin untuk menjaga kesehatan mata Anda.',
            ],
            [
                'kategori' => 'Ringan',
                'persentase_min' => 25.00,
                'persentase_max' => 49.99,
                'isi_saran' => 'Anda mengalami gejala Computer Vision Syndrome (CVS) tingkat ringan. Mulailah menerapkan kebiasaan sehat seperti mengatur jarak layar minimal 50-70 cm dari mata, gunakan aturan 20-20-20 (setiap 20 menit istirahat 20 detik dengan melihat objek sejauh 20 kaki/6 meter), kedipkan mata lebih sering, dan atur pencahayaan ruangan dengan baik. Jika gejala berlanjut, konsultasikan dengan dokter mata.',
            ],
            [
                'kategori' => 'Sedang',
                'persentase_min' => 50.00,
                'persentase_max' => 74.99,
                'isi_saran' => 'Anda mengalami gejala Computer Vision Syndrome (CVS) tingkat sedang yang memerlukan perhatian serius. Disarankan untuk mengurangi waktu penggunaan layar digital, terapkan aturan 20-20-20 secara konsisten, gunakan kacamata anti-radiasi blue light, dan gunakan tetes mata pelembab jika mata terasa kering. Segera konsultasikan kondisi Anda dengan dokter spesialis mata untuk evaluasi dan penanganan lebih lanjut.',
            ],
            [
                'kategori' => 'Berat',
                'persentase_min' => 75.00,
                'persentase_max' => 100.00,
                'isi_saran' => 'Anda mengalami gejala Computer Vision Syndrome (CVS) tingkat berat yang memerlukan penanganan medis segera. Hentikan atau kurangi drastis penggunaan perangkat digital, istirahatkan mata Anda, dan SEGERA konsultasikan dengan dokter spesialis mata untuk mendapatkan diagnosis dan perawatan yang tepat. Kondisi ini dapat menyebabkan kerusakan mata jangka panjang jika tidak ditangani dengan serius.',
            ],
        ];

        foreach ($saranData as $saran) {
            Saran::create($saran);
        }
    }
}