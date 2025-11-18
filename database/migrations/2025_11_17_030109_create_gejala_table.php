<?php
// database/migrations/2024_11_17_000003_create_gejala_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gejala', function (Blueprint $table) {
            $table->id(); // Primary Key: id
            $table->string('kode_gejala', 10)->unique();
            $table->text('deskripsi');
            $table->float('bobot')->default(0.0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Index
            $table->index('kode_gejala');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gejala');
    }
};