<?php
// app/Models/Pemeriksaan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'tanggal',
        'hasil_diagnosa',
        'persentase_cf',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'persentase_cf' => 'float',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_pemeriksaan', 'id');
    }

    public function inklusiEksklusi()
    {
        return $this->hasOne(InklusiEksklusi::class, 'id_pemeriksaan', 'id');
    }

    public function saran()
    {
        return $this->hasMany(Saran::class, 'id_pemeriksaan', 'id');
    }

    // Scopes
    public function scopeSelesai($query)
    {
        return $query->whereNotNull('hasil_diagnosa');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }
}