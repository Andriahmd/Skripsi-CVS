<?php
// database/migrations/2024_11_17_000004_create_inklusi_eksklusi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inklusi_eksklusi', function (Blueprint $table) {
            $table->id('id_inklusi_eksklusi'); // Custom PK name
            
            $table->foreignId('id_pemeriksaan')
                ->constrained('pemeriksaan', 'id')
                ->onDelete('cascade');
            
            
            $table->boolean('memenuhi_inklusi')->default(false);
            $table->boolean('ada_eksklusi')->default(false);
            
            $table->timestamps();
            
            // Index
            $table->index('id_pemeriksaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inklusi_eksklusi');
    }
};