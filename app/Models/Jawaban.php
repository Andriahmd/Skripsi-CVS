<?php
// app/Models/Jawaban.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban';
    protected $primaryKey = 'id_jawaban';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pemeriksaan',
        'id_gejala',
        'jawaban_text',
        'nilai_cf',
    ];

    protected $casts = [
        'nilai_cf' => 'float',
    ];

    // Relasi
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_pemeriksaan', 'id');
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class, 'id_gejala', 'id');
    }

    // Helper methods
    public static function getBobotFromText(string $text): float
    {
        $bobot = [
            'Tidak Pernah' => 0.0,
            'Kadang-kadang' => 0.4,
            'Cukup Sering' => 0.6,
            'Selalu' => 0.8,
        ];
        return $bobot[$text] ?? 0.0;
    }

    public static function getTextFromBobot(float $nilai): string
    {
        $map = [
            0.0 => 'Tidak Pernah',
            0.4 => 'Kadang-kadang',
            0.6 => 'Cukup Sering',
            0.8 => 'Selalu',
        ];
        return $map[$nilai] ?? 'Tidak Diketahui';
    }

    // Scopes
    public function scopeGejalaOnly($query)
    {
        return $query->whereNotNull('id_gejala');
    }

    public function scopeByPemeriksaan($query, $idPemeriksaan)
    {
        return $query->where('id_pemeriksaan', $idPemeriksaan);
    }
}