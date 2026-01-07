<?php

// -----------------------------------------------------------------------------
// RUTE APLIKASI (WEB & API)
// -----------------------------------------------------------------------------
// CATATAN UNTUK FRONTEND (FE):
// 1. Gunakan nama route (name('...')) untuk generate URL dinamis di Blade/JS.
// 2. Middleware 'auth' = Wajib Login (CMS/Admin).
// 3. Middleware 'guest' = Wajib Logout/Belum Login.
// 4. API Endpoints ada di bagian bawah file ini.
// -----------------------------------------------------------------------------

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SchoolController;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Registrations;
use App\Livewire\UserManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =========================================================================
// HALAMAN PUBLIK (FRONTEND)
// =========================================================================

// Landing page publik (form pendaftaran)
Route::get('/', function () {
    return view('pages.index');
})->name('index');

// =========================================================================
// OTENTIKASI (LOGIN/LOGOUT)
// =========================================================================

// Halaman Login (Hanya untuk yang belum login)
Route::get('/login', Login::class)->name('login')->middleware('guest');

// Proses Logout (Hapus sesi)
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// =========================================================================
// HALAMAN ADMIN / CMS (WAJIB LOGIN)
// =========================================================================

Route::middleware('auth')->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Halaman Data Pendaftaran (Tabel Registrasi)
    Route::get('/registrations', Registrations::class)->name('registrations');
    
    // Halaman Manajemen User (Admin)
    Route::get('/users', UserManagement::class)->name('users');
});

// =========================================================================
// API ENDPOINTS UNTUK FRONTEND (FORM REGISTRASI)
// =========================================================================
// Endpoint ini digunakan oleh form pendaftaran untuk validasi dan penyimpanan data.

// 1. API Cari Data Sekolah (Auto-complete)
// Method: GET
// URL Contoh: /api/schools/search?npsn=12345678
// Return: JSON Data Sekolah (nama, npsn, jenjang, dll)
// Sumber Data: https://sekolah.devapi.id/sekolah
Route::get('/api/schools/search', [SchoolController::class, 'search'])->name('api.schools.search');

// 2. API Download Template Excel Siswa
// Method: GET
// URL: /api/students/template
// Return: File Excel (.xlsx) dengan header dan dummy data
Route::get('/api/students/template', [RegistrationController::class, 'downloadTemplate'])->name('api.students.template');

// 3. API Submit Pendaftaran
// Method: POST
// URL: /api/registrations
Route::post('/api/registrations', [RegistrationController::class, 'store'])->name('api.registrations.store');
