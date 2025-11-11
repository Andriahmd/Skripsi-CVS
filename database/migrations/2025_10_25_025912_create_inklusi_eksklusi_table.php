<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inklusi_eksklusi', function (Blueprint $table) {
            $table->id('id_inklusi_eksklusi');
            $table->foreignId('id_periksa')
                ->nullable() 
                ->constrained('pemeriksaan')
                ->onDelete('cascade');
            $table->string('memenuhi_inklusi')->nullable();
            $table->string('ada_eksklusi')->nullable();
            $table->boolean('memenuhi')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inklusi_eksklusi');
    }
};
