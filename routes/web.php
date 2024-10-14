<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;



Route::middleware(['auth'])->group(function () {
    Route::get('/home', Home::class)->name('home');
});



Route::get('/', App\Livewire\Login::class)->name('login');


Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
