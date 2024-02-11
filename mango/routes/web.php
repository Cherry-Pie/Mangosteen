<?php

use App\Livewire\Auth;
use App\Livewire\Containers;
use App\Livewire\Scripts;
use App\Livewire\Settings;
use Illuminate\Support\Facades\Route;


Route::get('/login', Auth::class)->name('login')->middleware('guest');

Route::middleware('auth:mangosteen')->group(function () {
    Route::get('/containers', Containers::class)->name('dashboard');
    Route::get('/scripts', Scripts::class);
    Route::get('/settings', Settings::class);
});

Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});
