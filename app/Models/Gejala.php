<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $table = 'gejala'; // Eksplisit tabel
    protected $primaryKey = 'id';

    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode_gejala',
        'deskripsi',
        'bobot',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'bobot' => 'float',
        ];
    }

    /**
     * Relasi ke Jawaban
     */
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'id_gejala', 'id_gejala');
    }
}