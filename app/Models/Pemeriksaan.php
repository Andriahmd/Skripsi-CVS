<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaan'; // Eksplisit tabel kalau nama beda
    protected $primaryKey = 'id_periksa'; // Sesuaikan dengan migration
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_user',
        'tanggal',
        'hasil_diagnosa',
        'persentase_cf',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'persentase_cf' => 'float',
        ];
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Relasi ke Jawaban
     */
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_periksa', 'id_periksa');
    }

    /**
     * Relasi ke Saran
     */
    public function saran()
    {
        return $this->hasMany(Saran::class, 'id_periksa', 'id_periksa');
    }

    /**
     * Relasi ke InklusiEksklusi
     */
    public function inklusiEksklusi()
    {
        return $this->hasMany(InklusiEksklusi::class, 'id_periksa', 'id_periksa');
    }
}