<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/privacy-policy', fn() => view('pages.privacy-policy'))
    ->name('privacy.policy');

Route::get('/legal-notice', fn() => view('pages.legal-notice'))
    ->name('legal.notice');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.submit');
