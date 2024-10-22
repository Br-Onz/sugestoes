<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;


Route::middleware(['auth'])->group(function () {
    Route::get('/home', App\Livewire\Home::class)->name('home');
    Route::get('/avaliar', App\Livewire\Avaliar::class)->name('avaliar');
    Route::get('/solicitados', App\Livewire\Solicitados::class)->name('solicitados');
    Route::get('/gerar-pdf', [PDFController::class, 'gerarPDF'])->name('gerar-pdf');
    Route::get('/visualizar-pdf', [PDFController::class, 'visualizarPDF'])->name('visualizar-pdf');
});
Route::get('/', App\Livewire\Login::class)->name('login');
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
