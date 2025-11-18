<?php
// app/Models/Gejala.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $table = 'gejala';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kode_gejala',
        'deskripsi',
        'bobot',
        'is_active',
    ];

    protected $casts = [
        'bobot' => 'float',
        'is_active' => 'boolean',
    ];

    // Relasi
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_gejala', 'id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('kode_gejala');
    }
}