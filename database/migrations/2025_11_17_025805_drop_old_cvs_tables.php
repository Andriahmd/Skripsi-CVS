<?php
// database/migrations/2024_11_17_000001_drop_old_cvs_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop dalam urutan: child dulu, parent belakangan
        Schema::dropIfExists('jawaban');
        Schema::dropIfExists('saran');
        Schema::dropIfExists('inklusi_eksklusi');
        Schema::dropIfExists('pemeriksaan');
        Schema::dropIfExists('gejala');
    }

    public function down(): void
    {
        // Tidak ada rollback
    }
};