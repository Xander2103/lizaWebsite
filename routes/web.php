<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
