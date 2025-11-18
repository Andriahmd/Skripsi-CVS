<?php
// database/migrations/2024_11_17_000005_create_jawaban_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id('id_jawaban'); // Custom PK name

            // Relasi ke pemeriksaan (WAJIB)
            $table->foreignId('id_pemeriksaan')
                ->constrained('pemeriksaan', 'id')
                ->onDelete('cascade');

            // Relasi ke gejala (nullable)
            $table->foreignId('id_gejala')
                ->nullable()
                ->constrained('gejala', 'id')
                ->onDelete('cascade');

            // Jawaban user
            $table->string('jawaban_text', 50);

            // Nilai CF (untuk gejala saja)
            $table->float('nilai_cf')->nullable();

            $table->timestamps();

            // Index
            $table->index(['id_pemeriksaan', 'id_gejala']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};