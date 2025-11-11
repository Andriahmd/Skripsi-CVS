<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban'; // Eksplisit tabel
    protected $primaryKey = 'id_jawaban'; // Sesuaikan dengan migration
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_periksa',
        'id_gejala',
        'nilai_jawaban',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nilai_jawaban' => 'float',
        ];
    }

    /**
     * Relasi ke Pemeriksaan
     */
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_periksa', 'id_periksa');
    }

    /**
     * Relasi ke Gejala
     */
    public function gejala()
    {
        return $this->belongsTo(Gejala::class, 'id_gejala', 'id_gejala');
    }
}