<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('home');

Route::middleware(['auth', 'verified', 'auth.session'])->group(function (): void {
    Route::view('/dashboard', 'portal.dashboard')->name('dashboard');
    Route::view('/settings', 'portal.settings')->name('settings');
    Route::view('/billing', 'portal.billing')->name('billing');
});

Route::get('/robots.txt', function () {
    return response("User-agent: *\nDisallow: ".(config('illuna.noindex') ? '/' : '')."\n", 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
});
