<?php
// app/Models/Saran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saran extends Model
{
    protected $table = 'saran';
    protected $primaryKey = 'id_saran';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pemeriksaan',
        'isi_saran',
    ];

    // Relasi
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_pemeriksaan', 'id');
    }
}