<?php
// database/migrations/2024_11_17_000002_create_pemeriksaan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id(); // Primary Key: id
            
            $table->foreignId('id_user')
                ->constrained('users', 'id')
                ->onDelete('cascade');
            
            $table->dateTime('tanggal');
            $table->string('hasil_diagnosa', 100)->nullable();
            $table->float('persentase_cf')->default(0.0);
            
            $table->timestamps();
            
            // Index
            $table->index('id_user');
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};