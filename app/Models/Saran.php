<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saran extends Model
{
    protected $table = 'saran'; // Eksplisit tabel
    protected $primaryKey = 'id_saran'; // Sesuaikan dengan migration
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_periksa',
        'isi_saran',
    ];

    /**
     * Relasi ke Pemeriksaan
     */
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_periksa', 'id_periksa');
    }
}