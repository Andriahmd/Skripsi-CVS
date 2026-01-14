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
        'kategori',
        'persentase_min',
        'persentase_max',
        'isi_saran',
    ];

    protected $casts = [
        'persentase_min' => 'decimal:2',
        'persentase_max' => 'decimal:2',
    ];

    /**
     * Scope untuk mencari saran berdasarkan persentase
     */
    public function scopeByPersentase($query, $persentase)
    {
        return $query->where('persentase_min', '<=', $persentase)
                     ->where('persentase_max', '>=', $persentase);
    }

    /**
     * Scope untuk mencari saran berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}