# Dr Sue-Liza Eta Website Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Transform the reusable Laravel template into a premium medical specialist website for Dr Sue-Liza Eta with a split-hero, 7-section layout, warm elegant palette, config-driven structure, and careful medical wording.

**Architecture:** Config-first approach (all text/values driven by PHP config files). CSS design system in `client-site.css` with theme colors as CSS variables. Blade sections conditionally included based on `config('site.sections.*')`. Mobile-first responsive design. No hardcoded strings in views. Scroll reveal animations via lightweight JS observer. Medical authority prioritized over beauty (specialist first, not salon).

**Tech Stack:** Laravel 12, Tailwind v4, Vite, PHP config-driven templates, vanilla JS (no frameworks).

---

## File Structure Map

**Config files (updated):**
- `config/site.php` — name, tagline, nav, CTAs, approach steps, trust points, cta banner, sections toggles
- `config/theme.php` — warm ivory + deep navy + muted gold palette (CSS variables)
- `config/seo.php` — medical SEO meta tags
- `config/contact.php` — email, phone, English form request types
- `config/client-services.php` — 3 medical services
- `config/images.php` — placeholder paths (no changes needed)

**Blade views (created/modified):**
- `resources/views/layouts/client.blade.php` — lang="en"
- `resources/views/pages/home.blade.php` — add approach + cta-banner includes
- `resources/views/sections/hero.blade.php` — split layout redesign (text left, image right, trust indicators)
- `resources/views/sections/services.blade.php` — 3-col grid, SVG icon support
- `resources/views/sections/about.blade.php` — doctor-focused copy
- `resources/views/sections/trust.blade.php` — values cards (restyled)
- `resources/views/sections/approach.blade.php` — **NEW** 4-step patient journey
- `resources/views/sections/cta-banner.blade.php` — **NEW** simple CTA strip
- `resources/views/sections/contact.blade.php` — English labels, medical form types

**CSS:**
- `resources/css/client-site.css` — hero split layout, approach steps, cta banner, scroll reveal animations

**JavaScript:**
- `resources/js/app.js` — scroll reveal intersection observer

**Tests:**
- `tests/Feature/HomepageTest.php` — updated assertions for new client

---

## Implementation Tasks

### Task 1: Site Configuration

**Files:**
- Modify: `config/site.php`
- Modify: `config/theme.php`
- Modify: `config/seo.php`
- Modify: `config/contact.php`
- Modify: `config/client-services.php`

#### Step 1.1: Update config/site.php

Replace entire file with:

```php
<?php

return [
    // Basic info
    'name'          => 'Dr Sue-Liza Eta',
    'short_name'    => 'Dr Sue-Liza',
    'tagline'       => 'Specialist care with a personal, refined approach',
    'intro_short'   => 'Dr Sue-Liza Eta offers expert medical care across vascular surgery, medically guided weight loss and aesthetic medicine, with a focus on safety, clarity and individual attention.',
    'intro_long'    => 'With extensive experience in specialist medical care, Dr Sue-Liza Eta brings a patient-centred, evidence-informed approach to every consultation. Combining medical expertise with genuine care, she focuses on understanding your unique needs and providing personalised guidance in a calm, confidential setting.',
    'business_type' => 'medical specialist',

    // Navigation
    'nav_items' => [
        ['label' => 'Home',      'href' => '/'],
        ['label' => 'About',     'href' => '#about'],
        ['label' => 'Services',  'href' => '#services'],
        ['label' => 'Approach',  'href' => '#approach'],
        ['label' => 'Contact',   'href' => '#contact'],
    ],

    // CTAs
    'cta_primary'   => 'Book a consultation',
    'cta_secondary' => 'Our approach',

    // Contact
    'phone'   => '+1 (555) 123-4567',
    'address' => '123 Medical Plaza Drive',
    'city'    => 'New York',
    'region'  => 'NY',

    // Opening hours
    'opening_hours' => [
        'Monday – Friday' => '09:00 – 17:00',
        'Saturday'        => 'By appointment',
        'Sunday'          => 'Closed',
    ],

    // Hero trust indicators
    'trust_indicators' => [
        'Specialist care',
        'Personalised guidance',
        'Discreet consultations',
    ],

    // Approach / patient journey
    'approach_title' => 'Your consultation journey',
    'approach_steps' => [
        [
            'title' => 'Initial consultation',
            'description' => 'We start by listening. Understanding your goals, concerns and medical history in a relaxed, confidential setting.',
        ],
        [
            'title' => 'Personal assessment',
            'description' => 'A thorough, professional evaluation to determine the best approach for your individual needs and safety profile.',
        ],
        [
            'title' => 'Treatment plan',
            'description' => 'A clear, personalised plan outlining options, timelines and expected outcomes — with no pressure or surprise costs.',
        ],
        [
            'title' => 'Follow-up and guidance',
            'description' => 'Ongoing support and monitoring to ensure your comfort, safety and satisfaction throughout your journey.',
        ],
    ],

    // CTA banner
    'cta_banner_heading' => 'Ready to discuss your options?',
    'cta_banner_subheading' => 'Get in touch for a confidential consultation.',

    // Trust / values section
    'trust_points' => [
        'Medical expertise — board-certified specialist with extensive experience',
        'Personalised care — every consultation, every plan tailored to you',
        'Clear communication — transparent, no jargon, no pressure',
        'Safety first — your wellbeing is the only priority',
    ],

    // Section toggles
    'sections' => [
        'hero' => true,
        'services' => true,
        'about' => true,
        'approach' => true,
        'trust' => true,
        'cta_banner' => true,
        'contact' => true,
        'gallery' => false,
        'location' => false,
    ],

    // Footer
    'footer_text' => '© 2026 Dr Sue-Liza Eta — Confidential medical consultations',
    'whatsapp_url' => null,
    'maps_link' => '',
    'maps_embed_url' => '',
];
```

- [ ] **Step 1.2: Update config/theme.php**

Replace entire file with:

```php
<?php

return [
    'color_primary'      => '#1C2B3A',  // deep navy
    'color_primary_dark' => '#0F1D28',  // darker navy
    'color_secondary'    => '#EAE5DC',  // light warm gray
    'color_accent'       => '#C8A96E',  // muted gold
    'color_text'         => '#1C2B3A',  // navy
    'color_text_light'   => '#6B7A8A',  // blue-gray
    'color_bg'           => '#FDFAF6',  // warm ivory
    'color_bg_alt'       => '#F5F1EB',  // warm beige
    'color_border'       => '#E0D9CF',  // warm gray
];
```

- [ ] **Step 1.3: Update config/seo.php**

Replace entire file with:

```php
<?php

return [
    'title'       => 'Dr Sue-Liza Eta — Medical Specialist | Vascular Surgery, Medical Weight Loss, Aesthetic Medicine',
    'description' => 'Expert medical care from Dr Sue-Liza Eta. Specialising in vascular surgery, medically guided weight loss and aesthetic medicine. Safe, personalised, discreet consultations.',
    'keywords'    => ['vascular surgery', 'medical weight loss', 'aesthetic medicine', 'specialist consultation'],

    'og_title'       => 'Dr Sue-Liza Eta — Medical Specialist',
    'og_description' => 'Specialist care with a personal, refined approach.',
    'og_image'       => '/assets/client/hero.jpg',
    'og_type'        => 'website',
    'canonical_url'  => '',

    'noindex' => false,
];
```

- [ ] **Step 1.4: Update config/contact.php**

Replace entire file with:

```php
<?php

return [
    'phone'        => '+1 (555) 123-4567',
    'email'        => 'hello@drsueliza.com',
    'privacy_link' => '/privacy',

    'form_request_types' => [
        'Vascular Surgery consultation',
        'Medical Weight Loss consultation',
        'Aesthetic Medicine consultation',
        'General inquiry',
    ],
];
```

- [ ] **Step 1.5: Update config/client-services.php**

Replace entire file with:

```php
<?php

return [
    'items' => [
        [
            'name'        => 'Vascular Surgery',
            'description' => 'Specialist surgical care for vascular conditions. Personalised assessment, evidence-based techniques, expert follow-up care.',
            'icon'        => 'vascular',
        ],
        [
            'name'        => 'Medical Weight Loss',
            'description' => 'Evidence-based weight management with medical supervision. Personalised guidance, nutritional support, ongoing monitoring for sustainable results.',
            'icon'        => 'weight',
        ],
        [
            'name'        => 'Aesthetic Medicine',
            'description' => 'Minimally invasive treatments for natural-looking results. Subtle enhancements focused on enhancing what you already have.',
            'icon'        => 'aesthetic',
        ],
    ],
];
```

- [ ] **Step 1.6: Verify PHP syntax**

Run: `php -l config/site.php && php -l config/theme.php && php -l config/seo.php && php -l config/contact.php && php -l config/client-services.php`

Expected: No errors, "No syntax errors detected"

- [ ] **Step 1.7: Commit**

```bash
git add config/site.php config/theme.php config/seo.php config/contact.php config/client-services.php
git commit -m "config: update for Dr Sue-Liza Eta medical specialist site

- Site name, tagline, nav items, CTAs
- Warm ivory + deep navy + muted gold palette
- Approach steps, trust points, CTA banner config
- Medical specialist tone and ethical wording"
```

---

### Task 2: CSS Design System – Palette & Foundation

**Files:**
- Modify: `resources/css/client-site.css`

#### Step 2.1: Update theme colors section in CSS

After the existing `@layer base { ... }` block (around line 29), ensure the hero CSS uses warm background. Find the `.hero` block and verify it will work, then add new hero variant. Actually, the existing hero has dark overlay. We'll override it with a new `.hero-doctor` class.

Open `resources/css/client-site.css` and locate the `@layer components` section (line 76). Before the `/* --- Hero --- */` comment, verify existing `.hero` class will be kept (for backward compatibility). After the `.hero` block (line 170), add new hero split layout styles:

- [ ] **Add hero split layout CSS after line 170:**

```css
  /* Hero split layout — premium medical specialist variant */

  .hero-doctor {
    @apply relative;
    min-height: 100svh;
    background-color: var(--color-bg);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
  }

  @media (max-width: 768px) {
    .hero-doctor {
      grid-template-columns: 1fr;
      gap: 2rem;
      min-height: auto;
      padding: 4rem 0;
    }
  }

  .hero-doctor-content {
    @apply relative z-10 py-20 w-full;
  }

  .hero-doctor-content h1 {
    @apply text-4xl md:text-5xl lg:text-6xl font-bold mb-6;
    color: var(--color-text);
    text-wrap: balance;
  }

  .hero-doctor-content > p {
    @apply text-lg max-w-xl mb-6;
    color: var(--color-text-light);
    line-height: 1.75;
  }

  .hero-trust-indicators {
    @apply flex flex-col gap-3 mt-8 mb-6;
  }

  .hero-trust-badge {
    @apply flex items-center gap-2 text-sm font-medium;
    color: var(--color-text);
  }

  .hero-trust-badge::before {
    content: '✓';
    @apply inline-flex items-center justify-center w-5 h-5 rounded-full flex-shrink-0;
    background-color: var(--color-accent);
    color: #ffffff;
    font-size: 0.75rem;
  }

  .hero-doctor-image {
    @apply relative rounded-xl overflow-hidden;
    aspect-ratio: 4 / 5;
    min-height: 500px;
    background-size: cover;
    background-position: center;
    background-color: var(--color-secondary);
  }

  @media (max-width: 768px) {
    .hero-doctor-image {
      min-height: 300px;
    }
  }
```

- [ ] **Step 2.2: Add services grid override**

Locate the `.services-grid` class (around line 63). It currently uses `lg:grid-cols-4`. Override it to use 3 columns. Find the line and update it:

Change:
```css
  .services-grid {
    @apply grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6;
  }
```

To:
```css
  .services-grid {
    @apply grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6;
  }
```

- [ ] **Step 2.3: Verify CSS syntax**

Run: `npm run build 2>&1 | head -20`

Expected: Vite build succeeds or shows minor warnings (no CSS parse errors)

- [ ] **Step 2.4: Commit**

```bash
git add resources/css/client-site.css
git commit -m "css: add hero split layout and adjust services grid

- New .hero-doctor variant for split text/image layout
- Hero trust indicators with checkmark badges
- Mobile hero still shows image placeholder (not hidden)
- Services grid: 4 cols → 3 cols"
```

---

### Task 3: CSS – Approach Section, CTA Banner, Scroll Reveal

**Files:**
- Modify: `resources/css/client-site.css`

#### Step 3.1: Add approach section CSS

In `resources/css/client-site.css`, locate the end of the components layer (before `@layer utilities`). Add:

```css
  /* --- Approach / Patient Journey Section --- */

  .approach-section {
    @apply py-16 md:py-24;
    background-color: var(--color-bg);
  }

  .approach-steps-grid {
    @apply grid grid-cols-1 md:grid-cols-4 gap-8;
    margin-top: 3rem;
  }

  .step-card {
    @apply flex flex-col;
    position: relative;
  }

  .step-card::before {
    content: '';
    @apply absolute top-0 left-0 w-16 h-1;
    background-color: var(--color-accent);
  }

  .step-number {
    @apply text-5xl font-bold mb-4 mt-6;
    color: var(--color-accent);
  }

  .step-card h3 {
    @apply text-xl font-semibold mb-3;
    color: var(--color-primary);
  }

  .step-card p {
    @apply text-sm leading-relaxed;
    color: var(--color-text-light);
  }

  @media (max-width: 768px) {
    .approach-steps-grid {
      grid-template-columns: 1fr 1fr;
    }
  }

  @media (max-width: 480px) {
    .approach-steps-grid {
      grid-template-columns: 1fr;
    }
  }

  /* --- CTA Banner Section --- */

  .cta-banner {
    @apply py-20 md:py-24;
    background-color: var(--color-primary);
    color: #ffffff;
  }

  .cta-banner-content {
    @apply max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center;
  }

  .cta-banner-heading {
    @apply text-4xl md:text-5xl font-bold mb-4;
    color: #ffffff;
  }

  .cta-banner-subheading {
    @apply text-lg mb-8;
    color: rgba(255, 255, 255, 0.8);
  }

  .cta-banner .btn-primary {
    margin: 0 auto;
  }

  /* --- Scroll Reveal Animation --- */

  .reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
  }

  .reveal.is-visible {
    opacity: 1;
    transform: translateY(0);
  }
```

- [ ] **Step 3.2: Verify CSS syntax**

Run: `npm run build 2>&1 | grep -i error || echo "Build OK"`

Expected: "Build OK" or no error output

- [ ] **Step 3.3: Commit**

```bash
git add resources/css/client-site.css
git commit -m "css: add approach, cta-banner, and scroll reveal animations

- Approach section: 4-step journey cards with accent line, responsive grid
- CTA banner: navy background, centered content, white text
- Scroll reveal: fade-up animation on .reveal elements"
```

---

### Task 4: Create New Blade Sections – Approach & CTA Banner

**Files:**
- Create: `resources/views/sections/approach.blade.php`
- Create: `resources/views/sections/cta-banner.blade.php`

#### Step 4.1: Create sections/approach.blade.php

Create new file `resources/views/sections/approach.blade.php`:

```blade
@if(!empty(config('site.approach_steps')))
<section id="approach" class="approach-section">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">How It Works</span>
            <h2 class="section-title">{{ config('site.approach_title', 'Your consultation journey') }}</h2>
            <p class="section-intro">A clear, personalised process focused on understanding your needs.</p>
        </div>

        <div class="approach-steps-grid">
            @foreach(config('site.approach_steps', []) as $index => $step)
                <div class="step-card" data-reveal>
                    <span class="step-number">{{ $index + 1 }}</span>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['description'] }}</p>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif
```

- [ ] **Step 4.2: Create sections/cta-banner.blade.php**

Create new file `resources/views/sections/cta-banner.blade.php`:

```blade
<section id="cta-banner" class="cta-banner">
    <div class="cta-banner-content">

        <h2 class="cta-banner-heading">
            {{ config('site.cta_banner_heading', 'Ready to discuss your options?') }}
        </h2>

        @if(!empty(config('site.cta_banner_subheading')))
            <p class="cta-banner-subheading">
                {{ config('site.cta_banner_subheading') }}
            </p>
        @endif

        @if(!empty(config('site.cta_primary')))
            <a href="#contact" class="btn btn-primary">
                {{ config('site.cta_primary') }}
            </a>
        @endif

    </div>
</section>
```

- [ ] **Step 4.3: Verify Blade syntax**

Run: `php artisan tinker <<< "exit"` (just check Laravel boots without errors)

Expected: No errors, Tinker prompt appears

- [ ] **Step 4.4: Commit**

```bash
git add resources/views/sections/approach.blade.php resources/views/sections/cta-banner.blade.php
git commit -m "feat: add approach journey and cta-banner sections

- Approach: 4-step patient journey with numbered cards
- CTA banner: simple, centered navy strip with heading and CTA
- Both sections config-driven, with data-reveal for animations"
```

---

### Task 5: Redesign Hero Section – Split Layout

**Files:**
- Modify: `resources/views/sections/hero.blade.php`

#### Step 5.1: Replace hero.blade.php content

Replace entire file `resources/views/sections/hero.blade.php` with:

```blade
<section id="hero" class="hero-doctor">
    <div class="client-container hero-doctor-content">

        <h1>{{ config('site.tagline') }}</h1>

        <p>{{ config('site.intro_short') }}</p>

        <!-- Trust indicators -->
        @if(!empty(config('site.trust_indicators')))
            <div class="hero-trust-indicators">
                @foreach(config('site.trust_indicators', []) as $indicator)
                    <div class="hero-trust-badge">{{ $indicator }}</div>
                @endforeach
            </div>
        @endif

        <!-- CTAs -->
        <div class="cta-row">
            @if(!empty(config('site.cta_primary')))
                <a href="#contact" class="btn btn-primary">{{ config('site.cta_primary') }}</a>
            @endif
            @if(!empty(config('site.cta_secondary')))
                <a href="#approach" class="btn btn-secondary">{{ config('site.cta_secondary') }}</a>
            @endif
        </div>

        <!-- Phone note -->
        @if(!empty(config('site.phone')))
            <p class="cta-note">
                Or call: <a href="tel:{{ config('site.phone') }}">{{ config('site.phone') }}</a>
            </p>
        @endif

    </div>

    <!-- Image column -->
    <div>
        @if(!empty(config('images.hero')))
            <div class="hero-doctor-image" style="background-image: url('{{ asset(config('images.hero')) }}')"></div>
        @else
            <div class="hero-doctor-image image-fallback" aria-hidden="true">
                <span>Doctor/specialist image placeholder</span>
            </div>
        @endif
    </div>

</section>
```

- [ ] **Step 5.2: Update btn-secondary styling to work in hero**

The hero-doctor-content is inside a white/ivory background. The existing `.btn-secondary` uses navy border/text which won't show well on navy headings. We need to use `.btn-secondary` (which works on light backgrounds). Verify in `client-site.css` that `.btn-secondary` is defined correctly (it is, line 112-120). The CTA row uses `btn-secondary` which will work fine.

Run a quick visual check: `php artisan serve`

Expected: Can view at `http://localhost:8000`

- [ ] **Step 5.3: Commit**

```bash
git add resources/views/sections/hero.blade.php
git commit -m "refactor: redesign hero to split layout (text left, image right)

- Text column: headline, intro, trust indicators, CTAs, phone note
- Image column: doctor/specialist placeholder (4:5 aspect, visible on mobile)
- Trust indicators as small checkmark badges under copy
- Mobile: stacks to single column with image visible
- All values from config (no hardcoded strings)"
```

---

### Task 6: Update Existing Blade Sections – Services, About, Trust, Contact

**Files:**
- Modify: `resources/views/sections/services.blade.php`
- Modify: `resources/views/sections/about.blade.php`
- Modify: `resources/views/sections/trust.blade.php`
- Modify: `resources/views/sections/contact.blade.php`

#### Step 6.1: Update services.blade.php for SVG icon support

Replace `resources/views/sections/services.blade.php` with:

```blade
<section id="services" class="client-section">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">What We Offer</span>
            <h2 class="section-title">Our Services</h2>
            <p class="section-intro">Expert medical care tailored to your needs.</p>
        </div>

        <div class="services-grid">
            @foreach(config('client-services.items', []) as $service)
                <article class="service-card" data-reveal>
                    @if(!empty($service['icon']))
                        <div class="service-card-icon" aria-hidden="true">
                            @if($service['icon'] === 'vascular')
                                <svg viewBox="0 0 24 24" width="40" height="40" fill="var(--color-accent)">
                                    <path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2m0 2a8 8 0 100 16 8 8 0 000-16m-1 4h2v6h-2V8m3-2h2v8h-2V6m-6 1h2v7h-2V7z"/>
                                </svg>
                            @elseif($service['icon'] === 'weight')
                                <svg viewBox="0 0 24 24" width="40" height="40" fill="var(--color-accent)">
                                    <path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2m0 2a8 8 0 100 16 8 8 0 000-16m0 3a.5.5 0 01.5.5v6a.5.5 0 01-1 0v-6a.5.5 0 01.5-.5m-3 4a.5.5 0 01.5.5v2a.5.5 0 01-1 0v-2a.5.5 0 01.5-.5m6 0a.5.5 0 01.5.5v2a.5.5 0 01-1 0v-2a.5.5 0 01.5-.5z"/>
                                </svg>
                            @elseif($service['icon'] === 'aesthetic')
                                <svg viewBox="0 0 24 24" width="40" height="40" fill="var(--color-accent)">
                                    <path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2m0 2a8 8 0 100 16 8 8 0 000-16m-2.5 5a1.5 1.5 0 110 3 1.5 1.5 0 010-3m5 0a1.5 1.5 0 110 3 1.5 1.5 0 010-3m-2.5 5.5c1.657 0 3 .895 3 2v.5a.5.5 0 01-.5.5h-5a.5.5 0 01-.5-.5v-.5c0-1.105 1.343-2 3-2z"/>
                                </svg>
                            @else
                                <span>{{ $service['icon'] }}</span>
                            @endif
                        </div>
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

- [ ] **Step 6.2: Update about.blade.php**

Replace `resources/views/sections/about.blade.php` with:

```blade
<section id="about" class="client-section-alt">
    <div class="client-container">
        <div class="two-column-grid">

            <div>
                @if(!empty(config('images.about')))
                    <div class="about-image-frame"
                         style="background-image: url('{{ asset(config('images.about')) }}')">
                    </div>
                @else
                    <div class="image-fallback about-image-frame">
                        <span>Doctor/specialist image placeholder</span>
                    </div>
                @endif
            </div>

            <div>
                <span class="section-eyebrow">About</span>
                <h2 class="section-title">Your trusted medical specialist</h2>
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

- [ ] **Step 6.3: Update trust.blade.php**

Replace `resources/views/sections/trust.blade.php` with:

```blade
@if(!empty(config('site.trust_points')))
<section id="trust" class="client-section">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Why Choose Us</span>
            <h2 class="section-title">Our Values</h2>
            <p class="section-intro">Patient-centred care built on expertise, transparency, and trust.</p>
        </div>

        <div class="trust-grid">
            @foreach(config('site.trust_points') as $point)
                <div class="trust-card" data-reveal>
                    <span class="trust-card-check" aria-hidden="true">✓</span>
                    <p>{{ $point }}</p>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif
```

- [ ] **Step 6.4: Update contact.blade.php**

Replace `resources/views/sections/contact.blade.php` with:

```blade
<section id="contact" class="client-section">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Get in Touch</span>
            <h2 class="section-title">Book a consultation</h2>
            <p class="section-intro">Contact us to discuss your needs and schedule an appointment.</p>
        </div>

        <div class="two-column-grid">

            <div>
                <div class="contact-card">
                    @if(!empty(config('site.phone')))
                        <p><strong>Phone</strong><br>
                        <a href="tel:{{ config('site.phone') }}">{{ config('site.phone') }}</a></p>
                    @endif
                    @if(!empty(config('contact.email')))
                        <p><strong>Email</strong><br>
                        <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a></p>
                    @endif
                    @if(!empty(config('site.whatsapp_url')))
                        <p><a href="{{ config('site.whatsapp_url') }}" target="_blank" rel="noopener noreferrer">WhatsApp</a></p>
                    @endif
                </div>

                @if(!empty(config('site.opening_hours')))
                    <div class="info-card">
                        <p style="font-weight:600;color:var(--color-primary);margin:0 0 .5rem;">Hours</p>
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
                <form class="contact-form" action="#" method="POST">
                    @csrf

                    <div class="form-field">
                        <label for="contact-name">Name *</label>
                        <input type="text" id="contact-name" name="name" class="form-input"
                               placeholder="Your name" required autocomplete="name">
                    </div>

                    <div class="form-field">
                        <label for="contact-email">Email *</label>
                        <input type="email" id="contact-email" name="email" class="form-input"
                               placeholder="your@email.com" required autocomplete="email">
                    </div>

                    <div class="form-field">
                        <label for="contact-phone">Phone *</label>
                        <input type="tel" id="contact-phone" name="phone" class="form-input"
                               placeholder="Your phone number" required autocomplete="tel">
                    </div>

                    @if(!empty(config('contact.form_request_types')))
                        <div class="form-field">
                            <label for="contact-type">Consultation Type *</label>
                            <select id="contact-type" name="request_type" class="form-input" required>
                                <option value="" disabled selected>Choose a consultation type</option>
                                @foreach(config('contact.form_request_types') as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-field">
                        <label for="contact-message">Message *</label>
                        <textarea id="contact-message" name="message" class="form-input"
                                  rows="4" placeholder="Tell us more about your needs..." required></textarea>
                    </div>

                    <div class="form-checkbox">
                        <input type="checkbox" id="contact-privacy" name="privacy" required>
                        <label for="contact-privacy">
                            I agree my information will be used to respond to my inquiry.
                            @if(!empty(config('contact.privacy_link')))
                                <a href="{{ config('contact.privacy_link') }}" target="_blank">Privacy policy</a>.
                            @endif
                        </label>
                    </div>

                    <div class="form-submit-row">
                        <button type="submit" class="btn btn-primary">Send inquiry</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>
```

- [ ] **Step 6.5: Commit**

```bash
git add resources/views/sections/services.blade.php resources/views/sections/about.blade.php resources/views/sections/trust.blade.php resources/views/sections/contact.blade.php
git commit -m "refactor: update services, about, trust, contact sections

- Services: add SVG icon support (vascular, weight, aesthetic)
- About: doctor-focused copy, specialist positioning
- Trust: reframed as values with transparent, safety-first messaging
- Contact: English labels, medical consultation form types
- All sections use data-reveal for animations"
```

---

### Task 7: Update Layout & Page Assembly

**Files:**
- Modify: `resources/views/layouts/client.blade.php`
- Modify: `resources/views/pages/home.blade.php`

#### Step 7.1: Update client.blade.php – Change language

In `resources/views/layouts/client.blade.php`, line 2, change:

```blade
<html lang="nl">
```

To:

```blade
<html lang="en">
```

- [ ] **Step 7.2: Update home.blade.php – Add new sections**

In `resources/views/pages/home.blade.php`, replace the entire content section with:

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

    @if(config('site.sections.approach', true))
        @include('sections.approach')
    @endif

    @if(config('site.sections.trust', true))
        @include('sections.trust')
    @endif

    @if(config('site.sections.cta_banner', true))
        @include('sections.cta-banner')
    @endif

    @if(config('site.sections.contact', true))
        @include('sections.contact')
    @endif

    @if(config('site.sections.gallery', true))
        @include('sections.gallery')
    @endif

    @if(config('site.sections.location', true))
        @include('sections.location')
    @endif

@endsection
```

- [ ] **Step 7.3: Commit**

```bash
git add resources/views/layouts/client.blade.php resources/views/pages/home.blade.php
git commit -m "chore: update layout language and page assembly

- Layout: change from nl to en language
- Home page: add approach and cta-banner sections in correct order
- Section order: hero → services → about → approach → trust → cta-banner → contact"
```

---

### Task 8: Add Scroll Reveal Animation – JavaScript

**Files:**
- Modify: `resources/js/app.js`

#### Step 8.1: Add scroll reveal observer

In `resources/js/app.js`, after the existing import, add:

```javascript
import './bootstrap';

// Scroll reveal animation
(function() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px',
  };

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observe all elements with data-reveal attribute
  document.querySelectorAll('[data-reveal]').forEach(function(el) {
    observer.observe(el);
  });
})();
```

- [ ] **Step 8.2: Verify JavaScript syntax**

Run: `npx eslint resources/js/app.js 2>&1 || echo "ESLint check completed"`

Expected: No syntax errors (ESLint may not be configured, that's OK)

- [ ] **Step 8.3: Commit**

```bash
git add resources/js/app.js
git commit -m "feat: add scroll reveal animation via intersection observer

- Lightweight vanilla JS (no external libraries)
- Watches [data-reveal] elements
- Adds .is-visible class when in viewport
- CSS handles fade-up animation transition"
```

---

### Task 9: Update Tests

**Files:**
- Modify: `tests/Feature/HomepageTest.php`

#### Step 9.1: Update HomepageTest assertions

Replace `tests/Feature/HomepageTest.php` with:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_homepage_loads_successfully(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_homepage_contains_site_name(): void
    {
        $this->get('/')->assertSee('Dr Sue-Liza Eta');
    }

    public function test_homepage_contains_phone_number(): void
    {
        $this->get('/')->assertSee(config('site.phone'));
    }

    public function test_hero_section_displays(): void
    {
        $this->get('/')->assertSee(config('site.tagline'));
    }

    public function test_services_section_displays(): void
    {
        $this->get('/')->assertSee('Vascular Surgery');
        $this->get('/')->assertSee('Medical Weight Loss');
        $this->get('/')->assertSee('Aesthetic Medicine');
    }

    public function test_approach_section_displays(): void
    {
        $this->get('/')->assertSee('Initial consultation');
        $this->get('/')->assertSee('Personal assessment');
    }

    public function test_trust_section_displays(): void
    {
        $this->get('/')->assertSee('Medical expertise');
    }

    public function test_noindex_meta_rendered_when_enabled(): void
    {
        config(['seo.noindex' => true]);
        $this->get('/')->assertSee('<meta name="robots" content="noindex">', false);
    }

    public function test_gallery_section_disabled(): void
    {
        $this->get('/')->assertDontSee('id="gallery"', false);
    }

    public function test_location_section_disabled(): void
    {
        $this->get('/')->assertDontSee('id="location"', false);
    }

    public function test_contact_form_loads(): void
    {
        $this->get('/')->assertSee('id="contact-name"', false);
        $this->get('/')->assertSee('type="email"', false);
    }
}
```

- [ ] **Step 9.2: Run tests to verify they pass**

Run: `php artisan test tests/Feature/HomepageTest.php -v`

Expected: All tests pass

```
✓ test_homepage_loads_successfully
✓ test_homepage_contains_site_name
✓ test_homepage_contains_phone_number
✓ test_hero_section_displays
✓ test_services_section_displays
✓ test_approach_section_displays
✓ test_trust_section_displays
✓ test_noindex_meta_rendered_when_enabled
✓ test_gallery_section_disabled
✓ test_location_section_disabled
✓ test_contact_form_loads

Tests: 11 passed
```

- [ ] **Step 9.3: Commit**

```bash
git add tests/Feature/HomepageTest.php
git commit -m "test: update HomepageTest for Dr Sue-Liza Eta site

- Assert site name, phone, tagline
- Verify services, approach, trust sections display
- Verify gallery and location are disabled
- Verify contact form fields present
- All 11 tests passing"
```

---

### Task 10: Build & Final Verification

**Files:**
- (No file changes; verification only)

#### Step 10.1: Build CSS & JavaScript

Run: `npm run build`

Expected: Build succeeds with no errors

```
✓ 1234 modules transformed
  [dist/manifest.json] written
  dist/assets/app.xxxxx.css written
  dist/assets/app.xxxxx.js written
```

- [ ] **Step 10.2: Run full test suite**

Run: `php artisan test`

Expected: All tests pass (including any existing tests)

```
Tests: XX passed, 0 failed
```

- [ ] **Step 10.3: Verify homepage renders correctly**

Run: `php artisan serve` and visit `http://localhost:8000`

Expected:
- Page loads without errors
- Hero displays split layout (text left, image placeholder right)
- Trust indicators show under CTA buttons
- Services section shows 3 cards
- Approach section shows 4 numbered steps
- CTA banner displays with navy background
- Contact form displays
- Mobile: tap hamburger menu, hero image still visible below text
- Click on service/approach/contact links — smooth scroll works

- [ ] **Step 10.4: Check console for JavaScript errors**

In browser DevTools Console:

Expected: No errors (warnings OK, native browser warnings OK)

- [ ] **Step 10.5: Final commit**

```bash
git commit --allow-empty -m "chore: build artifacts generated and verified

- npm run build: successful, no CSS/JS errors
- php artisan test: all 11+ tests passing
- Homepage renders correctly with full design
- Mobile responsive, scroll animations working
- Hero split layout visible on all screen sizes
- Contact form functional"
```

---

## Verification Checklist (before claiming complete)

- [ ] All config files updated with Dr Sue-Liza data (site, theme, seo, contact, services)
- [ ] All new Blade sections created (approach, cta-banner)
- [ ] Hero redesigned to split layout (text left, image right)
- [ ] Trust indicators display in hero
- [ ] Mobile hero shows image placeholder (not hidden)
- [ ] All image paths config-driven (easy to swap later)
- [ ] CSS build succeeds (npm run build)
- [ ] All tests pass (php artisan test)
- [ ] Homepage renders without JS errors
- [ ] Section order correct (hero → services → about → approach → trust → cta-banner → contact)
- [ ] No hardcoded strings in Blade templates
- [ ] Medical wording careful (no "guaranteed", "instant", etc.)
- [ ] Warm ivory + deep navy + muted gold palette applied
- [ ] Form is simple (name, email, phone, service type, message, privacy consent)
- [ ] All commits made with clear messages
- [ ] No WIP or untracked files

