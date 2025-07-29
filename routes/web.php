<?php

use App\Http\Controllers\Controler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\DownloadPdfController;





Route::middleware('web')->group(function () {
    Route::get('/teste-sessao', function () {
        session(['teste' => 'ok']);
        return session('teste');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/{record}/pdf', [DownloadPdfController::class, 'download'])->name('relatorio.pdf.download');
});
