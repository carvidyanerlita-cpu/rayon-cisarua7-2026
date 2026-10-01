<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PhotocopyController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\PulangBarengController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication & Quick Testing Switcher
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');

// Dashboard Utama
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Absensi Piket & Sanksi Otomatis
Route::prefix('piket')->name('piket.')->group(function () {
    Route::get('/', [PiketController::class, 'index'])->name('index');
    Route::post('/status', [PiketController::class, 'updateStatus'])->name('update-status');
    Route::post('/resolve-sanction/{member}', [PiketController::class, 'resolveSanction'])->name('resolve-sanction');
});

// Ruang Pulang Bareng & Transportasi
Route::prefix('pulang')->name('pulang.')->group(function () {
    Route::get('/', [PulangBarengController::class, 'index'])->name('index');
    Route::post('/join', [PulangBarengController::class, 'join'])->name('join');
    Route::post('/cancel/{id}', [PulangBarengController::class, 'cancel'])->name('cancel');
    Route::post('/comment', [PulangBarengController::class, 'storeComment'])->name('comment');
});

// Bimbingan Konseling & Curhat Anonim
Route::prefix('bk')->name('bk.')->group(function () {
    Route::get('/', [BkController::class, 'index'])->name('index');
    Route::post('/article', [BkController::class, 'storeArticle'])->name('article.store');
    Route::post('/curhat', [BkController::class, 'storeCurhat'])->name('curhat.store');
    Route::post('/respond/{post}', [BkController::class, 'respondCurhat'])->name('curhat.respond');
    Route::delete('/bk/{post}', [BkController::class, 'destroy'])->name('bk.destroy');
});

Route::prefix('members')->name('members.')->middleware(['auth'])->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('index');
    Route::post('/', [MemberController::class, 'store'])->name('store');
    Route::put('/{member}', [MemberController::class, 'update'])->name('update');
    Route::delete('/{member}', [MemberController::class, 'destroy'])->name('destroy');
    Route::post('/{member}/toggle-sanction', [MemberController::class, 'toggleSanction'])->name('toggle-sanction');
    Route::post('/{member}/toggle-pkl', [MemberController::class, 'togglePkl'])->name('toggle-pkl');
});

// Layanan Fotokopi Sekitar
Route::prefix('photocopy')->name('photocopy.')->group(function () {
    Route::get('/', [PhotocopyController::class, 'index'])->name('index');
    Route::post('/', [PhotocopyController::class, 'store'])->name('store');
    Route::delete('/{photocopy}', [PhotocopyController::class, 'destroy'])->name('destroy');
});
