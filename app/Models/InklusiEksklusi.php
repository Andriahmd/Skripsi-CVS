<?php
// app/Models/InklusiEksklusi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InklusiEksklusi extends Model
{
    protected $table = 'inklusi_eksklusi';
    protected $primaryKey = 'id_inklusi_eksklusi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pemeriksaan',
        'memenuhi_inklusi',
        'ada_eksklusi',
    ];

    protected $casts = [
        'memenuhi_inklusi' => 'boolean',
        'ada_eksklusi' => 'boolean',
    ];

    // Relasi
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_pemeriksaan', 'id');
    }

    // Helper method
    public function lolosScreening(): bool
    {
        return $this->memenuhi_inklusi && !$this->ada_eksklusi;
    }

    // Scopes
    public function scopeLolos($query)
    {
        return $query->where('memenuhi_inklusi', true)
                     ->where('ada_eksklusi', false);
    }

    public function scopeTidakLolos($query)
    {
        return $query->where(function($q) {
            $q->where('memenuhi_inklusi', false)
              ->orWhere('ada_eksklusi', true);
        });
    }
}