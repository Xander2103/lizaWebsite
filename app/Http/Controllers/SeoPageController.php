<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeoPageController extends Controller
{
    public function show(string $slug)
    {
        $pages = config('seo-pages', []);

        abort_unless(array_key_exists($slug, $pages), 404);

        $page = $pages[$slug];

        $seo = [
            'title'         => $page['seo_title'],
            'description'   => $page['meta_description'],
            'canonical_url' => rtrim(config('app.url', 'https://drsuelizaeta.be'), '/') . '/' . $slug,
            'og_title'      => $page['og_title'],
            'og_description'=> $page['og_description'],
            'og_image'      => config('seo.og_image'),
            'og_type'       => 'website',
            'noindex'       => false,
        ];

        return view('pages.seo-landing', compact('page', 'seo'));
    }
}
