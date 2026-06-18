<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SeoPageController;
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

// Sitemap
Route::get('/sitemap.xml', function () {
    return response(view('sitemap')->render(), 200)
        ->header('Content-Type', 'text/xml');
})->name('sitemap');

// SEO landing pages
foreach (array_keys(config('seo-pages', [])) as $slug) {
    Route::get('/' . $slug, [SeoPageController::class, 'show'])
        ->defaults('slug', $slug)
        ->name('seo.' . str_replace('-', '.', $slug));
}
