<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
<link rel="icon" type="image/png" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<meta name="theme-color" content="#041b2d">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $seo['title'] ?? config('seo.title') }}</title>
    <meta name="description" content="{{ $seo['description'] ?? config('seo.description') }}">

    @if($seo['noindex'] ?? config('seo.noindex'))
        <meta name="robots" content="noindex">
    @endif

    @php $canonical = $seo['canonical_url'] ?? config('seo.canonical_url'); @endphp
    @if(!empty($canonical))
        <link rel="canonical" href="{{ $canonical }}">
    @endif

    <meta property="og:title"       content="{{ $seo['og_title'] ?? config('seo.og_title') }}">
    <meta property="og:description" content="{{ $seo['og_description'] ?? config('seo.og_description') }}">
    <meta property="og:image"       content="{{ $seo['og_image'] ?? config('seo.og_image') }}">
    <meta property="og:type"        content="{{ $seo['og_type'] ?? config('seo.og_type', 'website') }}">

    @if(config('images.favicon'))
        <link rel="icon" href="{{ asset(config('images.favicon')) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Theme colors only — full design system is in client-site.css --}}
    <style>
        :root {
            --color-primary:      {{ config('theme.color_primary') }};
            --color-primary-dark: {{ config('theme.color_primary_dark') }};
            --color-secondary:    {{ config('theme.color_secondary') }};
            --color-accent:       {{ config('theme.color_accent') }};
            --color-text:         {{ config('theme.color_text') }};
            --color-text-light:   {{ config('theme.color_text_light') }};
            --color-bg:           {{ config('theme.color_bg') }};
            --color-bg-alt:       {{ config('theme.color_bg_alt') }};
            --color-border:       {{ config('theme.color_border') }};
            --color-accent-light: {{ config('theme.color_accent_light') }};
            --color-accent-dark:  {{ config('theme.color_accent_dark') }};
        }
    </style>

    @stack('head')
</head>
<body class="client-page">

    @include('partials.nav')

    <main @if(!config('site.sections.hero', true)) class="has-fixed-nav" @endif>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')

</body>
</html>
