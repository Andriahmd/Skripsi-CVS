<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InklusiEksklusi extends Model
{
    protected $table = 'inklusi_eksklusi'; // Eksplisit tabel
    protected $primaryKey = 'id_inklusi_eksklusi'; // Sesuaikan dengan migration
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_periksa',
        'memenuhi_inklusi',
        'memenuhi',
        'ada_eksklusi',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'memenuhi_inklusi' => 'string',
            'memenuhi' => 'string',
            'ada_eksklusi' => 'string',
        ];
    }

    /**
     * Relasi ke Pemeriksaan
     */
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_periksa', 'id_periksa');
    }
}