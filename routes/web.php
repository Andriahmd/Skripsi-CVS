<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemeriksaanController;

//Public Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

//Public Pages (Anyone)
Route::view('/', 'index')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/saran', 'saran')->name('pages');

//Authenticated Routes Only (Harus Login)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman Kuis / Pemeriksaan
    Route::get('/pertanyaan', [PemeriksaanController::class, 'showForm'])->name('pertanyaan');

    // Endpoint JSON untuk Kuis (JS Fetch)
    Route::get('/pertanyaan-api', [PemeriksaanController::class, 'getPertanyaan'])->name('pertanyaan.api');

    // Group API (Untuk proses simpan & hitung via AJAX)
    Route::prefix('api')->group(function () {
        Route::post('/pemeriksaan', [PemeriksaanController::class, 'createPemeriksaan'])->name('api.pemeriksaan.create');
        Route::get('/pertanyaan', [PemeriksaanController::class, 'getPertanyaan'])->name('api.pertanyaan.get');
        Route::post('/screening', [PemeriksaanController::class, 'simpanScreening'])->name('api.screening.save');
        Route::post('/jawaban', [PemeriksaanController::class, 'simpanJawaban'])->name('api.jawaban.save');
        
        // Route Penting untuk Hitung Diagnosis
        Route::post('/diagnosis', [PemeriksaanController::class, 'hitungDiagnosis'])->name('api.diagnosis.calculate');
        
        Route::get('/riwayat', [PemeriksaanController::class, 'getRiwayat'])->name('api.riwayat.get');
    });

    // ✅ ROUTE HASIL (Ini yang akan dipanggil setelah selesai hitung)
    // Pastikan route ini ada di dalam middleware 'auth'
    Route::get('/hasil/{idPemeriksaan}', [PemeriksaanController::class, 'hasilDiagnosis'])
        ->name('hasil.show'); 
});

//Fallback (404)
Route::fallback(function () {
    return redirect()->route('home');
});