<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saran', function (Blueprint $table) {
            $table->id('id_saran');

            $table->enum('kategori', ['Tidak Mengalami', 'Ringan', 'Sedang', 'Berat'])
                ->comment('Kategori tingkat CVS');

            $table->decimal('persentase_min', 5, 2)->comment('Persentase minimum (misal: 0.00)');
            $table->decimal('persentase_max', 5, 2)->comment('Persentase maksimum (misal: 24.99)');

            $table->text('isi_saran')->comment('Saran yang akan ditampilkan');

            $table->timestamps();

            // Index untuk performa query
            $table->index('kategori');
            $table->index(['persentase_min', 'persentase_max']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saran');
    }
};