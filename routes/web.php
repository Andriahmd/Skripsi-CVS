<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('index'); // halaman utama
})->name('home');

Route::get('/about', function () {
    return view('about'); // file: resources/views/about.blade.php
})->name('about');

Route::get('/pertanyaan', function () {
    return view('pertanyaan'); // file: resources/views/pertanyaan.blade.php
})->name('pertanyaan');

Route::get('/pages', function () {
    return view('pages'); // nanti bikin resources/views/pages.blade.php
})->name('pages');

Route::get('/contact', function () {
    return view('contact'); // nanti bikin resources/views/contact.blade.php
})->name('contact');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');