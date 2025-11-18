<?php
// database/migrations/2024_11_17_000006_create_saran_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saran', function (Blueprint $table) {
            $table->id('id_saran'); // Custom PK name
            
            $table->foreignId('id_pemeriksaan')
                ->constrained('pemeriksaan', 'id')
                ->onDelete('cascade');
            
            $table->text('isi_saran');
            $table->timestamps();
            
            // Index
            $table->index('id_pemeriksaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saran');
    }
};