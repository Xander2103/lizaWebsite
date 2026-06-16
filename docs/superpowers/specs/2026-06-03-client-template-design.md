# Reusable Laravel Client Website Template — Design Spec

**Date:** 2026-06-03
**Project:** ClientWebsiteTemplate
**Goal:** Reusable Laravel 12 foundation for professional €750+ local business websites. New clients are created by editing config files, replacing images, and adjusting theme colors — no Blade changes required for a standard variant.

---

## 1. Architecture

### Pattern
Blade inheritance (Approach A):
- `layouts/client.blade.php` — full HTML shell with `@yield('content')` and `@stack` support
- `pages/home.blade.php` — extends layout, includes all section partials
- `partials/nav.blade.php` + `partials/footer.blade.php` — included by layout
- `sections/*.blade.php` — one file per page section, included by pages/home

### Routing
Single route in `routes/web.php`:
```php
Route::get('/', function () {
    return view('pages.home');
});
```
No controller. Config is read directly in Blade via `config()`.

### CSS
- Tailwind v4 is installed and stays
- `resources/css/client-site.css` holds the full design system using `@layer` + `@apply`
- `resources/css/app.css` imports it: `@import './client-site.css';`
- No changes to `vite.config.js`
- Only CSS custom properties (theme colors) are injected inline in the layout `<head>`

### Config-driven
All client-specific data lives in 6 config files. Blade never hardcodes business content.

---

## 2. Config Files

### `config/site.php`
```php
'name'           => 'Garage Stefan',
'tagline'        => 'Uw vertrouwde garage in Huldenberg',
'intro_short'    => 'Voor onderhoud, herstellingen en banden — snel, eerlijk en lokaal.',
'intro_long'     => 'Bij Garage Stefan bent u aan het juiste adres voor het onderhoud en herstel van uw wagen. Al meer dan 15 jaar helpen wij particulieren en bedrijven in de regio Huldenberg met vakkundige service en eerlijke prijzen. Kom langs of bel ons gerust.',
'business_type'  => 'garage',
'nav_items'      => [
    ['label' => 'Diensten',   'href' => '#services'],
    ['label' => 'Over ons',   'href' => '#about'],
    ['label' => 'Waarom ons', 'href' => '#trust'],
    ['label' => 'Galerij',    'href' => '#gallery'],
    ['label' => 'Contact',    'href' => '#contact'],
],
'footer_text'    => '© 2025 Garage Stefan — Tommestraat 124, 3040 Huldenberg',
'whatsapp_url'   => null,
'cta_primary'    => 'Maak een afspraak',
'cta_secondary'  => 'Bekijk onze diensten',
'phone'          => '0476 40 36 02',
'address'        => 'Tommestraat 124',
'city'           => 'Huldenberg',
'region'         => 'Vlaams-Brabant',
'opening_hours'  => [
    'Maandag – Vrijdag' => '08:00 – 18:00',
    'Zaterdag'          => '08:00 – 12:00',
    'Zondag'            => 'Gesloten',
],
'maps_link'      => '',
'maps_embed_url' => '',
'trust_points'   => [
    'Meer dan 15 jaar ervaring',
    'Eerlijke prijzen, geen verrassingen',
    'Snel geholpen, ook voor kleine herstellingen',
    'Lokale garage met persoonlijke service',
    'Transparante communicatie',
],
'sections'       => [
    'hero'     => true,
    'services' => true,
    'about'    => true,
    'trust'    => true,
    'gallery'  => true,
    'contact'  => true,
    'location' => true,
],
```

Each section key maps directly to the `@include` in `pages/home.blade.php`. Setting a key to `false` removes that section from the rendered page without any Blade edits. Default is `true` for all sections.

### `config/client-services.php`
```php
'items' => [
    ['name' => 'Onderhoud',     'description' => 'Regelmatig onderhoud verlengt de levensduur van uw wagen.', 'icon' => '🔧'],
    ['name' => 'Herstellingen', 'description' => 'Van kleine defecten tot grote herstellingen, wij lossen het op.', 'icon' => '🛠️'],
    ['name' => 'Bandenservice', 'description' => 'Montage, balancering en opslag van uw banden.', 'icon' => '⭕'],
    ['name' => 'Carrosserie',   'description' => 'Deukjes, krassen of grotere schade — wij herstellen uw carrosserie.', 'icon' => '🚗'],
],
```

### `config/contact.php`
```php
'phone'              => '0476 40 36 02',
'email'              => 'info@garagestefan.be',
'privacy_link'       => '#privacy',
'form_request_types' => ['Onderhoud', 'Herstelling', 'Banden', 'Carrosserie', 'Andere vraag'],
```

### `config/seo.php`
```php
'title'          => 'Garage Stefan — Onderhoud & Herstellingen in Huldenberg',
'description'    => 'Lokale garage in Huldenberg voor onderhoud, herstellingen, banden en carrosserie. Bel 0476 40 36 02.',
'keywords'       => ['garage Huldenberg', 'autoonderhoud', 'herstellingen', 'bandenservice', 'Vlaams-Brabant'],
'og_title'       => 'Garage Stefan — Uw vertrouwde garage in Huldenberg',
'og_description' => 'Snel, eerlijk en lokaal. Bel 0476 40 36 02.',
'og_image'       => '/assets/client/hero.jpg',
'og_type'        => 'website',
'canonical_url'  => '',
'noindex'        => false,
```
- `noindex: true` renders `<meta name="robots" content="noindex">` — useful during demo/preview builds
- `canonical_url` empty → no canonical tag rendered

### `config/theme.php`
```php
'color_primary'      => '#1a3a5c',
'color_primary_dark' => '#0f2540',
'color_secondary'    => '#e8f0f7',
'color_accent'       => '#d97706',
'color_text'         => '#1f2937',
'color_text_light'   => '#6b7280',
'color_bg'           => '#ffffff',
'color_bg_alt'       => '#f9fafb',
'color_border'       => '#e5e7eb',
```
These are injected as CSS custom properties in the layout `<head>`:
```html
<style>
:root {
  --color-primary: {{ config('theme.color_primary') }};
  ...
}
</style>
```

### `config/images.php`
```php
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
```
- Paths are passed through `asset()` in Blade
- `null` or empty string → element renders with `.image-fallback` CSS class (gradient placeholder)
- Non-null but missing file → browser 404 acceptable for now; layout never breaks visually

---

## 3. Blade File Structure

```
resources/views/
├── layouts/
│   └── client.blade.php          # Full HTML shell
├── partials/
│   ├── nav.blade.php             # Navigation + mobile toggle
│   └── footer.blade.php          # Footer with links and info
├── sections/
│   ├── hero.blade.php            # Hero with background image + CTA
│   ├── services.blade.php        # Service cards from config
│   ├── about.blade.php           # Two-column: image + intro_long
│   ├── trust.blade.php           # Trust point cards
│   ├── gallery.blade.php         # 4-image grid with fallback
│   ├── contact.blade.php         # Visual-only contact form
│   └── location.blade.php        # Opening hours + maps
└── pages/
    └── home.blade.php            # Composes all sections
```

### Section IDs (must match nav_items hrefs)
```
#services, #about, #trust, #gallery, #contact, #location
```

### Layout head details
- `<title>` from `config('seo.title')`
- `<meta name="description">` from `config('seo.description')`
- `<meta name="robots" content="noindex">` only if `config('seo.noindex') === true`
- Open Graph: og:title, og:description, og:image, og:type
- Favicon `<link>` only if `config('images.favicon')` is not null
- `@vite(['resources/css/app.css', 'resources/js/app.js'])`
- CSS variables `<style>` block (theme colors only)
- `@stack('head')` before `</head>`
- `@stack('scripts')` before `</body>`

### Navigation
- Logo: `config('images.logo')` if set, else business name as text
- Desktop links from `config('site.nav_items')`
- Primary CTA button: `config('site.cta_primary')` linking to `#contact`
- Mobile hamburger `.nav-toggle` toggles `.nav-mobile-panel`
- Mobile toggle JS via `@push('scripts')` in nav partial — toggles a CSS class only, no libraries

### Graceful degradation — general rule
No empty or null config value may cause a visible layout break, a PHP error, or a blank section. Every piece of optional data is guarded in Blade before rendering. Required fields (name, tagline, cta_primary) should always be filled, but the layout must not crash if they are not.

### Conditional rendering rules
- `whatsapp_url` — only render WhatsApp link if not null
- `images.logo` — only render `<img>` if not null; else render business name as text
- `images.favicon` — only render favicon `<link>` if not null
- `maps_embed_url` — if empty, show `.image-fallback` with text "Google Maps wordt hier gekoppeld."
- `maps_link` — only render external Maps button if not empty
- `contact.email` — only render email link if not empty
- `canonical_url` — only render canonical `<link>` if not empty
- `phone` — only render phone link/CTA note if not empty
- `cta_primary` — render button only if not empty; hero still renders without it
- `cta_secondary` — render button only if not empty
- `trust_points` — section renders only if array is not empty
- `opening_hours` — list renders only if array is not empty
- `site.sections.*` — each section is wrapped: `@if(config('site.sections.hero', true))` etc.

### Section toggling in `pages/home.blade.php`
```blade
@if(config('site.sections.hero', true))
    @include('sections.hero')
@endif
```
The `true` default means sections are on unless explicitly set to `false` in config.

### Hero image
```html
<section class="hero" style="--hero-image: url('{{ asset(config('images.hero')) }}')">
```
Only the image URL is inline. All styling is in `client-site.css` using `var(--hero-image)`.

### Contact form
- Visual-only. `action="#"`.
- Fields: name, phone, email (optional), request type `<select>`, message `<textarea>`
- Privacy checkbox: "Ik ga akkoord dat mijn gegevens gebruikt worden om mijn aanvraag te beantwoorden."
- Privacy link from `config('contact.privacy_link')`
- HTML comment in form explaining mail handling is not yet implemented
- No controllers, validation, DB, or mail logic

---

## 4. CSS System

**File:** `resources/css/client-site.css`
**Import:** Added to top of `resources/css/app.css` as `@import './client-site.css';`

### Layer order
```css
@layer base      /* resets, body defaults, typography */
@layer layout    /* page structure classes */
@layer components /* reusable semantic classes */
@layer utilities  /* small helpers */
```

### Semantic class inventory

**Layout:**
`.client-page`, `.client-section`, `.client-section-alt`, `.client-container`, `.section-header`, `.section-actions`, `.two-column-grid`

**Typography:**
`.section-eyebrow`, `.section-title`, `.section-intro`

**Buttons/CTAs:**
`.btn`, `.btn-primary`, `.btn-secondary`, `.cta-row`, `.cta-note`

**Cards:**
`.service-card`, `.trust-card`, `.info-card`, `.contact-card`

**Gallery/Images:**
`.gallery-grid`, `.gallery-item`, `.image-frame`, `.image-fallback`

**Opening hours:**
`.opening-hours-list`

**Navigation:**
`.nav-bar`, `.nav-logo`, `.nav-links`, `.nav-toggle`, `.nav-mobile-panel`, `.nav-mobile-link`

**Footer:**
`.footer-bar`

**Form:**
`.contact-form`, `.form-field`, `.form-input`, `.form-checkbox`, `.form-error`, `.form-help`, `.form-submit-row`

### Image fallback
`.image-fallback` applies a neutral gradient background so the layout never appears broken when an image is absent.

---

## 5. Page Section Order

1. Navigation (partial)
2. Hero — tagline, intro_short, 2 CTA buttons, phone link
3. Services — loop over client-services.items
4. About — two-column, image + intro_long
5. Trust — loop over site.trust_points
6. Gallery — 4-image grid
7. Contact — info card + visual form
8. Location — opening hours + Maps embed or fallback
9. Footer (partial)

---

## 6. New Client Workflow

To create a new client website from this template:

1. Duplicate or clone the project
2. Edit all 6 config files with client data
3. Drop images into `public/assets/client/` using the exact filenames
4. Adjust `config/theme.php` colors for the client's brand
5. Run `npm run build`
6. Done — no Blade changes needed for a standard client variant

---

## 7. Constraints & Non-Goals

**Not built in this starter version:**
- No admin panel
- No database or migrations
- No mail sending (contact form is visual-only)
- No multilingual / i18n support (single language, Dutch example)
- No external integrations (no analytics scripts, CRM, live chat, cookie banners, payment, API calls)
- No new Composer or npm packages
- No fake testimonials or fake review scores
- No Tailwind utility strings directly in Blade templates
- No anonymous Blade components
- No `config/services.php` modification (Laravel's default stays untouched)
- No privacy page or GDPR implementation (privacy link is a placeholder)

**Naming rules:**
- All config keys, CSS class names, Blade file names, and section IDs use generic names
- No business-specific names appear in code — only in config values
- CSS classes prefixed with `.client-` or named for function (`.hero`, `.service-card`), never for a specific client
- This rule ensures any future client variant requires zero code renaming
