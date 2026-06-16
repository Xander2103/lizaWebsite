# Reusable Laravel Client Website Template — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a config-driven Laravel 12 Blade website that renders a professional local business homepage at `/`, with Garage Stefan as the first example client.

**Architecture:** Blade inheritance — `layouts/client.blade.php` → `pages/home.blade.php` → `@include` sections. All client data lives in 6 config files. Tailwind v4 powers the design via `@apply` inside `@layer` blocks in `client-site.css`. No utility strings in Blade templates.

**Tech Stack:** Laravel 12, Blade, Tailwind v4 (`@layer` + `@apply`), Vite, PHPUnit

---

## File Map

**Create:**
- `config/site.php`
- `config/client-services.php`
- `config/contact.php`
- `config/seo.php`
- `config/theme.php`
- `config/images.php`
- `resources/css/client-site.css`
- `resources/views/layouts/client.blade.php`
- `resources/views/partials/nav.blade.php`
- `resources/views/partials/footer.blade.php`
- `resources/views/sections/hero.blade.php`
- `resources/views/sections/services.blade.php`
- `resources/views/sections/about.blade.php`
- `resources/views/sections/trust.blade.php`
- `resources/views/sections/gallery.blade.php`
- `resources/views/sections/contact.blade.php`
- `resources/views/sections/location.blade.php`
- `resources/views/pages/home.blade.php`
- `public/assets/client/.gitkeep`
- `tests/Feature/HomepageTest.php`

**Modify:**
- `routes/web.php` — change `welcome` to `pages.home`
- `resources/css/app.css` — prepend `@import './client-site.css';`

**Do not touch:**
- `vite.config.js`
- `config/services.php`
- `resources/js/app.js`

---

### Task 1: Write failing feature tests

**Files:**
- Create: `tests/Feature/HomepageTest.php`

- [ ] **Step 1: Create the test file**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_homepage_loads_successfully(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_homepage_contains_business_name(): void
    {
        $this->get('/')->assertSee(config('site.name'));
    }

    public function test_homepage_contains_phone_number(): void
    {
        $this->get('/')->assertSee(config('site.phone'));
    }

    public function test_noindex_meta_rendered_when_enabled(): void
    {
        config(['seo.noindex' => true]);
        $this->get('/')->assertSee('<meta name="robots" content="noindex">', false);
    }

    public function test_gallery_section_hidden_when_disabled(): void
    {
        config(['site.sections.gallery' => false]);
        $this->get('/')->assertDontSee('id="gallery"', false);
    }
}
```

- [ ] **Step 2: Run tests — confirm they fail**

```bash
php artisan test --filter HomepageTest
```

Expected: FAIL — view `welcome` not found or similar. This is correct at this stage.

---

### Task 2: Create all six config files

**Files:** `config/site.php`, `config/client-services.php`, `config/contact.php`, `config/seo.php`, `config/theme.php`, `config/images.php`

- [ ] **Step 1: Create `config/site.php`**

```php
<?php

return [
    'name'          => 'Garage Stefan',
    'tagline'       => 'Uw vertrouwde garage in Huldenberg',
    'intro_short'   => 'Voor onderhoud, herstellingen en banden — snel, eerlijk en lokaal.',
    'intro_long'    => 'Bij Garage Stefan bent u aan het juiste adres voor het onderhoud en herstel van uw wagen. Al meer dan 15 jaar helpen wij particulieren en bedrijven in de regio Huldenberg met vakkundige service en eerlijke prijzen. Kom langs of bel ons gerust.',
    'business_type' => 'garage',

    'nav_items' => [
        ['label' => 'Diensten',   'href' => '#services'],
        ['label' => 'Over ons',   'href' => '#about'],
        ['label' => 'Waarom ons', 'href' => '#trust'],
        ['label' => 'Galerij',    'href' => '#gallery'],
        ['label' => 'Contact',    'href' => '#contact'],
    ],

    'footer_text'   => '© 2025 Garage Stefan — Tommestraat 124, 3040 Huldenberg',
    'whatsapp_url'  => null,
    'cta_primary'   => 'Maak een afspraak',
    'cta_secondary' => 'Bekijk onze diensten',

    'phone'   => '0476 40 36 02',
    'address' => 'Tommestraat 124',
    'city'    => 'Huldenberg',
    'region'  => 'Vlaams-Brabant',

    'opening_hours' => [
        'Maandag – Vrijdag' => '08:00 – 18:00',
        'Zaterdag'          => '08:00 – 12:00',
        'Zondag'            => 'Gesloten',
    ],

    'maps_link'      => '',
    'maps_embed_url' => '',

    'trust_points' => [
        'Meer dan 15 jaar ervaring',
        'Eerlijke prijzen, geen verrassingen',
        'Snel geholpen, ook voor kleine herstellingen',
        'Lokale garage met persoonlijke service',
        'Transparante communicatie',
    ],

    'sections' => [
        'hero'     => true,
        'services' => true,
        'about'    => true,
        'trust'    => true,
        'gallery'  => true,
        'contact'  => true,
        'location' => true,
    ],
];
```

- [ ] **Step 2: Create `config/client-services.php`**

```php
<?php

return [
    'items' => [
        [
            'name'        => 'Onderhoud',
            'description' => 'Regelmatig onderhoud verlengt de levensduur van uw wagen.',
            'icon'        => '🔧',
        ],
        [
            'name'        => 'Herstellingen',
            'description' => 'Van kleine defecten tot grote herstellingen, wij lossen het op.',
            'icon'        => '🛠️',
        ],
        [
            'name'        => 'Bandenservice',
            'description' => 'Montage, balancering en opslag van uw banden.',
            'icon'        => '⭕',
        ],
        [
            'name'        => 'Carrosserie',
            'description' => 'Deukjes, krassen of grotere schade — wij herstellen uw carrosserie.',
            'icon'        => '🚗',
        ],
    ],
];
```

- [ ] **Step 3: Create `config/contact.php`**

```php
<?php

return [
    'phone'        => '0476 40 36 02',
    'email'        => 'info@garagestefan.be',
    'privacy_link' => '#privacy',

    'form_request_types' => [
        'Onderhoud',
        'Herstelling',
        'Banden',
        'Carrosserie',
        'Andere vraag',
    ],
];
```

- [ ] **Step 4: Create `config/seo.php`**

```php
<?php

return [
    'title'       => 'Garage Stefan — Onderhoud & Herstellingen in Huldenberg',
    'description' => 'Lokale garage in Huldenberg voor onderhoud, herstellingen, banden en carrosserie. Bel 0476 40 36 02.',
    'keywords'    => ['garage Huldenberg', 'autoonderhoud', 'herstellingen', 'bandenservice', 'Vlaams-Brabant'],

    'og_title'       => 'Garage Stefan — Uw vertrouwde garage in Huldenberg',
    'og_description' => 'Snel, eerlijk en lokaal. Bel 0476 40 36 02.',
    'og_image'       => '/assets/client/hero.jpg',
    'og_type'        => 'website',
    'canonical_url'  => '',

    'noindex' => false,
];
```

- [ ] **Step 5: Create `config/theme.php`**

```php
<?php

return [
    'color_primary'      => '#1a3a5c',
    'color_primary_dark' => '#0f2540',
    'color_secondary'    => '#e8f0f7',
    'color_accent'       => '#d97706',
    'color_text'         => '#1f2937',
    'color_text_light'   => '#6b7280',
    'color_bg'           => '#ffffff',
    'color_bg_alt'       => '#f9fafb',
    'color_border'       => '#e5e7eb',
];
```

- [ ] **Step 6: Create `config/images.php`**

```php
<?php

return [
    'hero'    => 'assets/client/hero.jpg',
    'about'   => 'assets/client/about.jpg',
    'logo'    => null,
    'favicon' => null,

    'gallery' => [
        'assets/client/gallery-1.jpg',
        'assets/client/gallery-2.jpg',
        'assets/client/gallery-3.jpg',
        'assets/client/gallery-4.jpg',
    ],
];
```

- [ ] **Step 7: Commit**

```bash
git add config/site.php config/client-services.php config/contact.php config/seo.php config/theme.php config/images.php
git commit -m "feat: add client config files with Garage Stefan example data"
```

---

### Task 3: Route, CSS import, asset directory

**Files:**
- Modify: `routes/web.php`
- Modify: `resources/css/app.css`
- Create: `public/assets/client/.gitkeep`

- [ ] **Step 1: Replace `routes/web.php`**

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});
```

- [ ] **Step 2: Update `resources/css/app.css`**

Replace the full file contents — add the import as the first line:

```css
@import './client-site.css';
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
        'Segoe UI Symbol', 'Noto Color Emoji';
}
```

- [ ] **Step 3: Create asset directory**

```bash
mkdir -p public/assets/client && touch public/assets/client/.gitkeep
```

- [ ] **Step 4: Commit**

```bash
git add routes/web.php resources/css/app.css public/assets/client/.gitkeep
git commit -m "feat: wire route to pages.home, add CSS import and asset directory"
```

---

### Task 4: CSS design system

**Files:**
- Create: `resources/css/client-site.css`

- [ ] **Step 1: Create `resources/css/client-site.css`**

```css
/* ============================================================
   Client Site — Design System
   Tailwind v4 @layer + @apply. Theme colors via CSS variables.
   No utility strings in Blade templates.
   ============================================================ */

@layer base {
  *, *::before, *::after { box-sizing: border-box; }

  html { scroll-behavior: smooth; }

  body {
    @apply font-sans text-base leading-relaxed m-0;
    color: var(--color-text);
    background-color: var(--color-bg);
  }

  h1, h2, h3, h4, h5, h6 {
    line-height: 1.2;
    color: var(--color-text);
    margin-top: 0;
  }

  a { color: inherit; }

  img { max-width: 100%; display: block; }

  ul, ol { list-style: none; margin: 0; padding: 0; }
}

@layer layout {
  .client-page {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  .client-section {
    @apply py-16 md:py-24;
  }

  .client-section-alt {
    @apply py-16 md:py-24;
    background-color: var(--color-bg-alt);
  }

  .client-container {
    @apply max-w-6xl mx-auto px-4 sm:px-6 lg:px-8;
  }

  .section-header {
    @apply text-center mb-12;
  }

  .section-actions {
    @apply flex flex-wrap gap-4 justify-center mt-10;
  }

  .two-column-grid {
    @apply grid md:grid-cols-2 gap-12 items-center;
  }

  .services-grid {
    @apply grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6;
  }

  .trust-grid {
    @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4;
  }

  .has-fixed-nav {
    padding-top: 4rem;
  }
}

@layer components {

  /* Typography */
  .section-eyebrow {
    @apply text-sm font-semibold uppercase tracking-widest mb-3 block;
    color: var(--color-accent);
  }

  .section-title {
    @apply text-3xl md:text-4xl font-bold mb-4;
    color: var(--color-text);
  }

  .section-intro {
    @apply text-lg max-w-2xl mx-auto;
    color: var(--color-text-light);
  }

  /* Buttons */
  .btn {
    @apply inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold text-sm transition-all duration-200 no-underline cursor-pointer;
    border: 2px solid transparent;
    white-space: nowrap;
  }

  .btn-primary {
    @apply btn;
    background-color: var(--color-accent);
    border-color: var(--color-accent);
    color: #ffffff;

    &:hover { filter: brightness(0.9); }
  }

  .btn-secondary {
    @apply btn;
    background-color: transparent;
    border-color: var(--color-primary);
    color: var(--color-primary);

    &:hover {
      background-color: var(--color-primary);
      color: #ffffff;
    }
  }

  /* Light variant for use on dark backgrounds (hero) */
  .btn-secondary-light {
    @apply btn;
    background-color: transparent;
    border-color: rgba(255, 255, 255, 0.6);
    color: #ffffff;

    &:hover { background-color: rgba(255, 255, 255, 0.15); }
  }

  /* CTA areas */
  .cta-row {
    @apply flex flex-wrap gap-4 items-center mt-8;
  }

  .cta-note {
    @apply text-sm mt-4 block;
    color: rgba(255, 255, 255, 0.75);

    a {
      color: #ffffff;
      font-weight: 600;
      text-decoration: none;

      &:hover { text-decoration: underline; }
    }
  }

  /* Hero */
  .hero {
    @apply relative flex items-center;
    min-height: 100svh;
    background-color: var(--color-primary);
    background-image: var(--hero-image, none);
    background-size: cover;
    background-position: center;

    &::before {
      content: '';
      @apply absolute inset-0;
      background: linear-gradient(135deg, rgba(15, 37, 64, 0.88) 0%, rgba(26, 58, 92, 0.6) 100%);
    }
  }

  .hero-content {
    @apply relative z-10 py-20 w-full;

    h1 {
      @apply text-4xl md:text-5xl lg:text-6xl font-bold mb-6;
      color: #ffffff;
      text-wrap: balance;
    }

    > p {
      @apply text-xl max-w-xl mb-2;
      color: rgba(255, 255, 255, 0.85);
    }
  }

  /* Cards */
  .service-card {
    @apply p-6 rounded-xl;
    border: 1px solid var(--color-border);
    background-color: var(--color-bg);
    transition: box-shadow 0.2s ease, transform 0.2s ease;

    &:hover {
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      transform: translateY(-2px);
    }

    .service-card-icon { @apply text-3xl mb-4 block; }

    h3 {
      @apply text-lg font-semibold mb-2;
      color: var(--color-primary);
    }

    p {
      @apply text-sm leading-relaxed;
      color: var(--color-text-light);
    }
  }

  .trust-card {
    @apply flex items-start gap-4 p-5 rounded-xl;
    background-color: var(--color-bg);
    border: 1px solid var(--color-border);

    .trust-card-check {
      @apply text-xl flex-shrink-0;
      color: var(--color-accent);
      margin-top: 2px;
    }

    p {
      @apply font-medium m-0;
      color: var(--color-text);
    }
  }

  .info-card {
    @apply p-6 rounded-xl;
    background-color: var(--color-bg-alt);
    border: 1px solid var(--color-border);
  }

  .contact-card {
    @apply p-6 rounded-xl mb-6;
    background-color: var(--color-secondary);
    border: 1px solid var(--color-border);

    p { @apply mb-2; color: var(--color-text); }

    a {
      color: var(--color-primary);
      font-weight: 600;
      text-decoration: none;

      &:hover { text-decoration: underline; }
    }
  }

  /* Gallery / images */
  .gallery-grid {
    @apply grid grid-cols-2 md:grid-cols-4 gap-4;
  }

  .gallery-item {
    @apply rounded-xl overflow-hidden;
    aspect-ratio: 1 / 1;
    background-size: cover;
    background-position: center;
    background-color: var(--color-secondary);
  }

  .image-frame {
    @apply rounded-xl overflow-hidden;

    img { @apply w-full h-full object-cover; }
  }

  .image-fallback {
    @apply rounded-xl flex items-center justify-center text-center p-8;
    background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-bg-alt) 100%);
    border: 2px dashed var(--color-border);
    color: var(--color-text-light);
    min-height: 240px;
    font-size: 0.875rem;
  }

  /* Opening hours */
  .opening-hours-list {
    @apply mt-4;

    li {
      @apply flex justify-between text-sm py-2 border-b;
      border-color: var(--color-border);

      &:last-child { border-bottom: none; }

      .hours-day { color: var(--color-text-light); }
      .hours-time { font-weight: 600; color: var(--color-text); }
    }
  }

  /* Navigation */
  .nav-bar {
    @apply fixed top-0 left-0 right-0 z-50 flex items-center justify-between h-16 px-4 sm:px-6;
    background-color: var(--color-bg);
    border-bottom: 1px solid var(--color-border);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
  }

  .nav-logo {
    @apply font-bold text-lg no-underline;
    color: var(--color-primary);
  }

  .nav-links {
    @apply hidden md:flex items-center gap-8;

    a {
      @apply text-sm font-medium no-underline transition-colors duration-150;
      color: var(--color-text-light);

      &:hover { color: var(--color-primary); }
    }
  }

  /* Desktop CTA in nav — hidden on mobile */
  .nav-cta-btn {
    @apply hidden md:inline-flex;
  }

  .nav-toggle {
    @apply flex md:hidden flex-col gap-1.5 p-2 cursor-pointer border-none bg-transparent;

    span {
      @apply block w-6 transition-all duration-200;
      height: 2px;
      background-color: var(--color-text);
      border-radius: 2px;
    }
  }

  .nav-mobile-panel {
    @apply fixed inset-0 z-40 flex-col items-center justify-center gap-6;
    background-color: var(--color-bg);
    display: none;

    &.is-open { display: flex; }
  }

  .nav-mobile-link {
    @apply text-xl font-semibold no-underline py-2;
    color: var(--color-primary);

    &:hover { color: var(--color-accent); }
  }

  /* Footer */
  .footer-bar {
    @apply mt-auto py-12;
    background-color: var(--color-primary);
    color: rgba(255, 255, 255, 0.8);

    a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;

      &:hover { color: #ffffff; }
    }
  }

  .footer-grid {
    @apply grid md:grid-cols-3 gap-8;
  }

  .footer-heading {
    @apply font-semibold mb-3 text-sm uppercase tracking-wide;
    color: #ffffff;
  }

  .footer-nav-list {
    @apply flex flex-col gap-2;

    a { @apply text-sm; }
  }

  .footer-meta-list {
    @apply flex flex-col gap-1;

    li { @apply text-sm; color: rgba(255, 255, 255, 0.7); }
  }

  .footer-bottom {
    @apply mt-8 pt-6 text-sm text-center;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    color: rgba(255, 255, 255, 0.5);
  }

  /* Forms */
  .contact-form { @apply flex flex-col gap-5; }

  .form-field {
    @apply flex flex-col gap-1;

    label { @apply text-sm font-medium; color: var(--color-text); }
  }

  .form-input {
    @apply w-full rounded-lg px-4 py-3 text-sm transition-colors duration-150;
    border: 1px solid var(--color-border);
    color: var(--color-text);
    background-color: var(--color-bg);
    font-family: inherit;

    &:focus {
      outline: none;
      border-color: var(--color-primary);
      box-shadow: 0 0 0 3px rgba(26, 58, 92, 0.1);
    }

    &::placeholder { color: var(--color-text-light); }
  }

  .form-checkbox {
    @apply flex items-start gap-3 mt-2;

    input[type="checkbox"] {
      @apply flex-shrink-0 cursor-pointer mt-0.5;
      width: 1rem;
      height: 1rem;
      accent-color: var(--color-primary);
    }

    label {
      @apply text-sm;
      color: var(--color-text-light);

      a { color: var(--color-primary); text-decoration: underline; }
    }
  }

  .form-error  { @apply text-xs mt-1; color: #dc2626; }
  .form-help   { @apply text-xs mt-1; color: var(--color-text-light); }

  .form-submit-row { @apply flex items-center gap-4 flex-wrap pt-2; }
}

@layer utilities {
  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
  }

  .text-balance { text-wrap: balance; }
}
```

- [ ] **Step 2: Commit**

```bash
git add resources/css/client-site.css
git commit -m "feat: add full CSS design system with Tailwind v4 @layer"
```

---

### Task 5: Blade layout

**Files:**
- Create: `resources/views/layouts/client.blade.php`

- [ ] **Step 1: Create `resources/views/layouts/client.blade.php`**

```blade
<!DOCTYPE html>
<html lang="nl">
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
        }
    </style>

    @stack('head')
</head>
<body class="client-page">

    @include('partials.nav')

    <main class="has-fixed-nav">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')

</body>
</html>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/layouts/client.blade.php
git commit -m "feat: add Blade layout with SEO, OG tags and theme variables"
```

---

### Task 6: Nav and footer partials

**Files:**
- Create: `resources/views/partials/nav.blade.php`
- Create: `resources/views/partials/footer.blade.php`

- [ ] **Step 1: Create `resources/views/partials/nav.blade.php`**

```blade
<nav class="nav-bar" aria-label="Hoofdnavigatie">

    <a href="/" class="nav-logo" aria-label="{{ config('site.name') }}">
        @if(config('images.logo'))
            <img src="{{ asset(config('images.logo')) }}" alt="{{ config('site.name') }}" height="40">
        @else
            {{ config('site.name') }}
        @endif
    </a>

    <ul class="nav-links" role="list">
        @foreach(config('site.nav_items', []) as $item)
            <li><a href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
        @endforeach
    </ul>

    @if(!empty(config('site.cta_primary')))
        <a href="#contact" class="btn btn-primary nav-cta-btn">
            {{ config('site.cta_primary') }}
        </a>
    @endif

    <button
        class="nav-toggle"
        id="nav-toggle"
        aria-label="Menu openen"
        aria-expanded="false"
        aria-controls="nav-mobile-panel"
    >
        <span></span>
        <span></span>
        <span></span>
    </button>

</nav>

<div
    class="nav-mobile-panel"
    id="nav-mobile-panel"
    role="dialog"
    aria-modal="true"
    aria-label="Mobiel menu"
    aria-hidden="true"
>
    @foreach(config('site.nav_items', []) as $item)
        <a href="{{ $item['href'] }}" class="nav-mobile-link">{{ $item['label'] }}</a>
    @endforeach

    @if(!empty(config('site.cta_primary')))
        <a href="#contact" class="btn btn-primary">{{ config('site.cta_primary') }}</a>
    @endif
</div>

@push('scripts')
<script>
(function () {
    var toggle = document.getElementById('nav-toggle');
    var panel  = document.getElementById('nav-mobile-panel');
    if (!toggle || !panel) return;

    function openMenu() {
        panel.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
        panel.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        panel.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        panel.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', function () {
        panel.classList.contains('is-open') ? closeMenu() : openMenu();
    });

    panel.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });
}());
</script>
@endpush
```

- [ ] **Step 2: Create `resources/views/partials/footer.blade.php`**

```blade
<footer class="footer-bar">
    <div class="client-container">
        <div class="footer-grid">

            <div>
                <p class="footer-heading">{{ config('site.name') }}</p>
                <p style="font-size:.875rem;margin:0 0 .4rem;">{{ config('site.address') }}, {{ config('site.city') }}</p>
                @if(!empty(config('site.phone')))
                    <p style="font-size:.875rem;margin:0 0 .25rem;">
                        <a href="tel:{{ config('site.phone') }}">{{ config('site.phone') }}</a>
                    </p>
                @endif
                @if(!empty(config('contact.email')))
                    <p style="font-size:.875rem;margin:0;">
                        <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a>
                    </p>
                @endif
            </div>

            <div>
                <p class="footer-heading">Navigatie</p>
                <ul class="footer-nav-list" role="list">
                    @foreach(config('site.nav_items', []) as $item)
                        <li><a href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="footer-heading">Openingsuren</p>
                @if(!empty(config('site.opening_hours')))
                    <ul class="footer-meta-list" role="list">
                        @foreach(config('site.opening_hours') as $day => $hours)
                            <li>{{ $day }}: {{ $hours }}</li>
                        @endforeach
                    </ul>
                @endif
                @if(!empty(config('contact.privacy_link')))
                    <p style="margin-top:1rem;font-size:.875rem;">
                        <a href="{{ config('contact.privacy_link') }}">Privacybeleid</a>
                    </p>
                @endif
            </div>

        </div>
        <div class="footer-bottom">{{ config('site.footer_text') }}</div>
    </div>
</footer>
```

- [ ] **Step 3: Commit**

```bash
git add resources/views/partials/nav.blade.php resources/views/partials/footer.blade.php
git commit -m "feat: add nav and footer partials"
```

---

### Task 7: Hero, Services, About sections

**Files:**
- Create: `resources/views/sections/hero.blade.php`
- Create: `resources/views/sections/services.blade.php`
- Create: `resources/views/sections/about.blade.php`

- [ ] **Step 1: Create `resources/views/sections/hero.blade.php`**

```blade
<section
    id="hero"
    class="hero"
    @if(!empty(config('images.hero')))style="--hero-image: url('{{ asset(config('images.hero')) }}')"@endif
    aria-label="Welkom bij {{ config('site.name') }}"
>
    <div class="client-container hero-content">

        <h1>{{ config('site.tagline') }}</h1>

        <p>{{ config('site.intro_short') }}</p>

        <div class="cta-row">
            @if(!empty(config('site.cta_primary')))
                <a href="#contact" class="btn btn-primary">{{ config('site.cta_primary') }}</a>
            @endif
            @if(!empty(config('site.cta_secondary')))
                <a href="#services" class="btn btn-secondary-light">{{ config('site.cta_secondary') }}</a>
            @endif
        </div>

        @if(!empty(config('site.phone')))
            <p class="cta-note">
                Of bel direct: <a href="tel:{{ config('site.phone') }}">{{ config('site.phone') }}</a>
            </p>
        @endif

    </div>
</section>
```

- [ ] **Step 2: Create `resources/views/sections/services.blade.php`**

```blade
<section id="services" class="client-section">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Wat wij doen</span>
            <h2 class="section-title">Onze diensten</h2>
            <p class="section-intro">
                Professionele service voor uw voertuig — van onderhoud tot carrosserie.
            </p>
        </div>

        <div class="services-grid">
            @foreach(config('client-services.items', []) as $service)
                <article class="service-card">
                    @if(!empty($service['icon']))
                        <span class="service-card-icon" aria-hidden="true">{{ $service['icon'] }}</span>
                    @endif
                    <h3>{{ $service['name'] }}</h3>
                    <p>{{ $service['description'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="section-actions">
            @if(!empty(config('site.cta_primary')))
                <a href="#contact" class="btn btn-primary">{{ config('site.cta_primary') }}</a>
            @endif
        </div>

    </div>
</section>
```

- [ ] **Step 3: Create `resources/views/sections/about.blade.php`**

```blade
<section id="about" class="client-section-alt">
    <div class="client-container">
        <div class="two-column-grid">

            <div>
                @if(!empty(config('images.about')))
                    <div class="image-frame" style="aspect-ratio:4/3;">
                        <img
                            src="{{ asset(config('images.about')) }}"
                            alt="Over {{ config('site.name') }}"
                            loading="lazy"
                        >
                    </div>
                @else
                    <div class="image-fallback" style="aspect-ratio:4/3;min-height:280px;">
                        <span>Afbeelding wordt hier geplaatst</span>
                    </div>
                @endif
            </div>

            <div>
                <span class="section-eyebrow">Over ons</span>
                <h2 class="section-title">Uw lokale {{ config('site.business_type', 'vakman') }}</h2>
                <p style="color:var(--color-text-light);line-height:1.75;margin-bottom:1.5rem;">
                    {{ config('site.intro_long') }}
                </p>
                @if(!empty(config('site.cta_primary')))
                    <a href="#contact" class="btn btn-primary">{{ config('site.cta_primary') }}</a>
                @endif
            </div>

        </div>
    </div>
</section>
```

- [ ] **Step 4: Commit**

```bash
git add resources/views/sections/hero.blade.php resources/views/sections/services.blade.php resources/views/sections/about.blade.php
git commit -m "feat: add hero, services and about sections"
```

---

### Task 8: Trust, Gallery, Contact, Location sections

**Files:**
- Create: `resources/views/sections/trust.blade.php`
- Create: `resources/views/sections/gallery.blade.php`
- Create: `resources/views/sections/contact.blade.php`
- Create: `resources/views/sections/location.blade.php`

- [ ] **Step 1: Create `resources/views/sections/trust.blade.php`**

```blade
@if(!empty(config('site.trust_points')))
<section id="trust" class="client-section">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Waarom ons</span>
            <h2 class="section-title">Wat ons onderscheidt</h2>
            <p class="section-intro">Wij geloven in eerlijkheid, kwaliteit en persoonlijke service.</p>
        </div>

        <div class="trust-grid">
            @foreach(config('site.trust_points') as $point)
                <div class="trust-card">
                    <span class="trust-card-check" aria-hidden="true">✓</span>
                    <p>{{ $point }}</p>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif
```

- [ ] **Step 2: Create `resources/views/sections/gallery.blade.php`**

```blade
<section id="gallery" class="client-section-alt">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Sfeerbeelden</span>
            <h2 class="section-title">Een blik in onze garage</h2>
        </div>

        <div class="gallery-grid">
            @foreach(config('images.gallery', []) as $index => $imagePath)
                @if(!empty($imagePath))
                    <div
                        class="gallery-item"
                        style="background-image:url('{{ asset($imagePath) }}')"
                        role="img"
                        aria-label="Galerij afbeelding {{ $index + 1 }}"
                    ></div>
                @else
                    <div class="gallery-item image-fallback" aria-hidden="true">
                        <span>Foto {{ $index + 1 }}</span>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</section>
```

- [ ] **Step 3: Create `resources/views/sections/contact.blade.php`**

```blade
<section id="contact" class="client-section">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Contact</span>
            <h2 class="section-title">Maak een afspraak</h2>
            <p class="section-intro">Vul het formulier in en wij nemen zo snel mogelijk contact met u op.</p>
        </div>

        <div class="two-column-grid">

            <div>
                <div class="contact-card">
                    @if(!empty(config('site.phone')))
                        <p><strong>Telefoon</strong><br>
                        <a href="tel:{{ config('site.phone') }}">{{ config('site.phone') }}</a></p>
                    @endif
                    @if(!empty(config('contact.email')))
                        <p><strong>E-mail</strong><br>
                        <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a></p>
                    @endif
                    @if(!empty(config('site.whatsapp_url')))
                        <p><a href="{{ config('site.whatsapp_url') }}" target="_blank" rel="noopener noreferrer">WhatsApp ons</a></p>
                    @endif
                    <p style="margin:0;"><strong>Adres</strong><br>
                    {{ config('site.address') }}, {{ config('site.city') }}</p>
                </div>

                @if(!empty(config('site.opening_hours')))
                    <div class="info-card">
                        <p class="footer-heading" style="color:var(--color-primary);font-size:1rem;text-transform:none;letter-spacing:0;">Openingsuren</p>
                        <ul class="opening-hours-list" role="list">
                            @foreach(config('site.opening_hours') as $day => $hours)
                                <li>
                                    <span class="hours-day">{{ $day }}</span>
                                    <span class="hours-time">{{ $hours }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div>
                {{-- Visual-only form. Mail handling will be added in a later version. --}}
                <form class="contact-form" action="#" method="POST">
                    @csrf

                    <div class="form-field">
                        <label for="contact-name">Naam *</label>
                        <input type="text" id="contact-name" name="name" class="form-input"
                               placeholder="Uw naam" required autocomplete="name">
                    </div>

                    <div class="form-field">
                        <label for="contact-phone">Telefoonnummer *</label>
                        <input type="tel" id="contact-phone" name="phone" class="form-input"
                               placeholder="Uw telefoonnummer" required autocomplete="tel">
                    </div>

                    <div class="form-field">
                        <label for="contact-email">
                            E-mailadres <span style="color:var(--color-text-light);font-weight:400;">(optioneel)</span>
                        </label>
                        <input type="email" id="contact-email" name="email" class="form-input"
                               placeholder="uw@email.be" autocomplete="email">
                    </div>

                    @if(!empty(config('contact.form_request_types')))
                        <div class="form-field">
                            <label for="contact-type">Type aanvraag *</label>
                            <select id="contact-type" name="request_type" class="form-input" required>
                                <option value="" disabled selected>Kies een optie</option>
                                @foreach(config('contact.form_request_types') as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-field">
                        <label for="contact-message">Bericht *</label>
                        <textarea id="contact-message" name="message" class="form-input"
                                  rows="4" placeholder="Beschrijf uw aanvraag..." required></textarea>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="contact-privacy" name="privacy" required>
                        <label for="contact-privacy">
                            Ik ga akkoord dat mijn gegevens gebruikt worden om mijn aanvraag te beantwoorden.
                            @if(!empty(config('contact.privacy_link')))
                                <a href="{{ config('contact.privacy_link') }}" target="_blank">Meer info</a>.
                            @endif
                        </label>
                    </div>

                    <div class="form-submit-row">
                        <button type="submit" class="btn btn-primary">Verstuur aanvraag</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>
```

- [ ] **Step 4: Create `resources/views/sections/location.blade.php`**

```blade
<section id="location" class="client-section-alt">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Locatie</span>
            <h2 class="section-title">Hoe ons vinden</h2>
        </div>

        <div class="two-column-grid">

            <div class="info-card">
                <p class="footer-heading" style="color:var(--color-primary);font-size:1rem;text-transform:none;letter-spacing:0;">
                    {{ config('site.name') }}
                </p>
                <p style="color:var(--color-text-light);margin-bottom:1rem;">
                    {{ config('site.address') }}<br>
                    {{ config('site.city') }}, {{ config('site.region') }}
                </p>
                @if(!empty(config('site.phone')))
                    <p style="margin-bottom:.5rem;">
                        <a href="tel:{{ config('site.phone') }}"
                           style="color:var(--color-primary);font-weight:600;text-decoration:none;">
                            {{ config('site.phone') }}
                        </a>
                    </p>
                @endif
                @if(!empty(config('site.opening_hours')))
                    <ul class="opening-hours-list" role="list" style="margin-top:1.5rem;">
                        @foreach(config('site.opening_hours') as $day => $hours)
                            <li>
                                <span class="hours-day">{{ $day }}</span>
                                <span class="hours-time">{{ $hours }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if(!empty(config('site.maps_link')))
                    <a href="{{ config('site.maps_link') }}" target="_blank" rel="noopener noreferrer"
                       class="btn btn-secondary" style="margin-top:1.5rem;">
                        Bekijk op Google Maps
                    </a>
                @endif
            </div>

            <div>
                @if(!empty(config('site.maps_embed_url')))
                    <div style="border-radius:.75rem;overflow:hidden;height:360px;">
                        <iframe
                            src="{{ config('site.maps_embed_url') }}"
                            width="100%" height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Locatie {{ config('site.name') }} op Google Maps"
                        ></iframe>
                    </div>
                @else
                    <div class="image-fallback" style="min-height:360px;">
                        <span>Google Maps wordt hier gekoppeld.</span>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
```

- [ ] **Step 5: Commit**

```bash
git add resources/views/sections/trust.blade.php resources/views/sections/gallery.blade.php resources/views/sections/contact.blade.php resources/views/sections/location.blade.php
git commit -m "feat: add trust, gallery, contact and location sections"
```

---

### Task 9: Home page

**Files:**
- Create: `resources/views/pages/home.blade.php`

- [ ] **Step 1: Create `resources/views/pages/home.blade.php`**

```blade
@extends('layouts.client')

@section('content')

    @if(config('site.sections.hero', true))
        @include('sections.hero')
    @endif

    @if(config('site.sections.services', true))
        @include('sections.services')
    @endif

    @if(config('site.sections.about', true))
        @include('sections.about')
    @endif

    @if(config('site.sections.trust', true))
        @include('sections.trust')
    @endif

    @if(config('site.sections.gallery', true))
        @include('sections.gallery')
    @endif

    @if(config('site.sections.contact', true))
        @include('sections.contact')
    @endif

    @if(config('site.sections.location', true))
        @include('sections.location')
    @endif

@endsection
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/pages/home.blade.php
git commit -m "feat: add home page composing all sections with toggle guards"
```

---

### Task 10: Tests, build, verify

- [ ] **Step 1: Run feature tests**

```bash
php artisan test --filter HomepageTest
```

Expected: 5 tests, 5 passed.

Troubleshooting:
- `test_homepage_contains_business_name` fails → check `config/site.php` has `'name' => 'Garage Stefan'` and nav/footer render `config('site.name')`
- `test_noindex_meta_rendered_when_enabled` fails → confirm layout has `@if(config('seo.noindex')) <meta name="robots" content="noindex"> @endif` with exactly that string, no extra whitespace inside the tag
- `test_gallery_section_hidden_when_disabled` fails → confirm `pages/home.blade.php` wraps gallery include in `@if(config('site.sections.gallery', true))`

- [ ] **Step 2: Verify route list**

```bash
php artisan route:list
```

Expected: one GET `/` route returning `pages.home`.

- [ ] **Step 3: Build assets**

```bash
npm run build
```

Expected: Vite compiles without errors. Output in `public/build/`.

If `@apply` errors: check that every class name used after `@apply` in `client-site.css` is a valid Tailwind v4 utility. Custom class names cannot be used in `@apply` — only Tailwind utilities.

- [ ] **Step 4: Start dev server and verify visually**

```bash
php artisan serve
```

Open `http://localhost:8000`. Confirm:
- Fixed nav with business name and links
- Full-height hero with heading, two CTA buttons, phone note
- Services grid (4 cards)
- About section (image fallback visible since no image files exist yet)
- Trust cards (5 points)
- Gallery grid (gradient fallback blocks)
- Contact form with all fields and privacy checkbox
- Location section with Maps fallback text
- Footer with three columns

- [ ] **Step 5: Final commit**

```bash
git add tests/Feature/HomepageTest.php
git commit -m "feat: complete reusable Laravel client website template — Garage Stefan example"
```

---

## Spec Coverage

| Requirement | Task |
|---|---|
| 6 config files, all keys | Task 2 |
| `sections` toggles in site.php | Task 2, Task 9 |
| Route GET / → pages.home | Task 3 |
| CSS import in app.css | Task 3 |
| public/assets/client/ directory | Task 3 |
| Full CSS @layer system, all 30+ classes | Task 4 |
| Blade layout: SEO, OG, theme vars, @stack | Task 5 |
| Nav: logo fallback, config links, mobile panel, @push JS | Task 6 |
| Footer: 3-column, conditional phone/email | Task 6 |
| Hero: image var, CTA guards, phone note | Task 7 |
| Services: config loop, empty guard | Task 7 |
| About: two-column, image fallback | Task 7 |
| Trust: section guard, config loop | Task 8 |
| Gallery: per-image fallback | Task 8 |
| Contact: visual-only form, privacy, request types | Task 8 |
| Location: opening hours, maps embed or fallback | Task 8 |
| Home page with all section toggles | Task 9 |
| Feature tests (200, name, phone, noindex, toggle) | Task 1, 10 |
| npm run build | Task 10 |
| php artisan route:list | Task 10 |

No gaps found.
