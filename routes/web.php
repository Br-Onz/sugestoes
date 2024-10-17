<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/home', App\Livewire\Home::class)->name('home');
    Route::get('/avaliar', App\Livewire\Avaliar::class)->name('avaliar');
    Route::get('/solicitados', App\Livewire\Solicitados::class)->name('solicitados');
});



Route::get('/', App\Livewire\Login::class)->name('login');


Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
