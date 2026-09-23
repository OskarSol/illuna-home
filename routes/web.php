<?php

use App\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('home');

Route::get('/docs', [DocumentationController::class, 'index'])->name('docs.index');
Route::get('/docs/{page}', [DocumentationController::class, 'show'])->where('page', '[a-z0-9-]+')->name('docs.show');

Route::middleware(['auth', 'verified', 'auth.session'])->group(function (): void {
    Route::view('/dashboard', 'portal.dashboard')->name('dashboard');
    Route::view('/settings', 'portal.settings')->name('settings');
    Route::view('/billing', 'portal.billing')->name('billing');
});

Route::get('/robots.txt', function () {
    return response("User-agent: *\nDisallow: ".(config('illuna.noindex') ? '/' : '')."\n", 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
});
