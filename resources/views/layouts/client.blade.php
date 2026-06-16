<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('seo.title') }}</title>
    <meta name="description" content="{{ config('seo.description') }}">

    @if(config('seo.noindex'))
        <meta name="robots" content="noindex">
    @endif

    @if(!empty(config('seo.canonical_url')))
        <link rel="canonical" href="{{ config('seo.canonical_url') }}">
    @endif

    <meta property="og:title"       content="{{ config('seo.og_title') }}">
    <meta property="og:description" content="{{ config('seo.og_description') }}">
    <meta property="og:image"       content="{{ config('seo.og_image') }}">
    <meta property="og:type"        content="{{ config('seo.og_type', 'website') }}">

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
