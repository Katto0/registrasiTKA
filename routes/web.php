<?php

// -----------------------------------------------------------------------------
// Rute aplikasi (untuk Front-End dan Admin)
// Catatan:
// - Semua halaman admin menggunakan Livewire Component.
// - Middleware 'auth' artinya hanya bisa diakses setelah login.
// - Middleware 'guest' artinya hanya bisa diakses jika BELUM login.
// - Name() digunakan oleh FE untuk membuat link dengan route helper.
// -----------------------------------------------------------------------------

use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Registrations;
use App\Livewire\UserManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing page publik (form pendaftaran umum)
Route::get('/', function () {
    return view('pages.index');
})->name('index');

// Halaman Login (guest-only) → Livewire: Login
Route::get('/login', Login::class)->name('login')->middleware('guest');

// Dashboard Admin (auth-only) → Livewire: Dashboard
Route::get('/dashboard', Dashboard::class)->middleware('auth')->name('dashboard');
// Data Pendaftaran (auth-only) → Livewire: Registrations
Route::get('/registrations', Registrations::class)->middleware('auth')->name('registrations');
// Manajemen Pengguna (auth-only) → Livewire: UserManagement
Route::get('/users', UserManagement::class)->middleware('auth')->name('users');

// Logout (POST) → menghapus session dan kembali ke halaman login
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');
