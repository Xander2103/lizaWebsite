# Dr Sue-Liza Eta Medical Specialist Website — Design Specification

**Date:** 2026-06-12  
**Client:** Dr Sue-Liza Eta  
**Project:** Premium medical specialist website (Laravel template variant)  
**Status:** Design approved, ready for implementation

---

## 1. Project Overview

A premium, single-page medical specialist website for Dr Sue-Liza Eta, focused on three core services:
- Vascular Surgery
- Medical Weight Loss (evidence-based, medically guided)
- Aesthetic Medicine (minimally invasive, safety-first)

**Tone:** Premium, medically authoritative, calm, trustworthy, feminine but professional, clean, elegant.

**Positioning:** Specialist care with a personal, refined approach. Patient-centred, discreet, evidence-informed.

**Constraints:**
- No exaggerated medical claims (no "guaranteed," "instant," "perfect," "quick weight loss")
- Use careful medical wording: personalised, medically guided, consultation-based, patient-centred, safe, discreet, evidence-informed
- Config-driven architecture (no hardcoded strings in views)
- Elegant placeholders for now; easy photo replacement later
- No complex backend yet (form is visual only; mail routing added later)
- Mobile-first responsive design

---

## 2. Visual Identity

### Palette

Warm, premium, medical-friendly. Inspired by medical aesthetic + luxury wellness.

```
Primary background:    #FDFAF6   (warm ivory)
Secondary background:  #F5F1EB   (warm beige)
Primary (navy):        #1C2B3A   (deep navy)
Primary dark:          #0F1D28   (darker navy)
Accent (gold):         #C8A96E   (muted champagne/gold)
Secondary:             #EAE5DC   (light warm gray)
Text primary:          #1C2B3A   (same as navy)
Text secondary:        #6B7A8A   (blue-gray)
Border:                #E0D9CF   (warm gray)
```

Implemented via CSS variables in `resources/css/app.css` theme block (set from `config/theme.php`).

### Typography

- **Font family:** Instrument Sans (existing Tailwind config)
- **Headings:** Bold, uppercase eyebrows for section labels, balanced line-height
- **Body:** Relaxed leading (1.75), plenty of whitespace

### Design Language

- Clean, symmetrical layouts
- Rounded corners (border-radius: 0.75rem on cards/buttons)
- Subtle shadows on hover (no dramatic effects)
- Generous padding and spacing (premium feel)
- Elegant image frames with consistent aspect ratios

---

## 3. Section Breakdown

### 3.1 — Navigation & Header

**Location:** Fixed top, persistent across sections

- Logo text: "Dr Sue-Liza Eta" (left-aligned)
- Navigation menu: Home, About, Services, Approach, Contact (center, hidden on mobile)
- Primary CTA button: "Book a consultation" (right, desktop only)
- Mobile hamburger: Three-line menu, opens full-screen overlay
- Background: warm ivory with subtle top border
- Shadow: light (box-shadow: 0 1px 3px rgba(0,0,0,0.06))

**Copy:** All from `config('site.nav_items')` and `config('site.cta_primary')`

---

### 3.2 — Hero Section (NEW LAYOUT)

**Section ID:** `#hero`  
**Config keys:** `site.name`, `site.tagline`, `site.intro_short`, `site.cta_primary`, `site.cta_secondary`, `images.hero`, `site.trust_indicators` (new)

**Layout:** Split, text left, image right
- **Desktop:** 60% text / 40% image
- **Mobile:** Single column, stacked (image as soft visual block below text)

**Left column (text):**
- Headline (h1): Bold, large (48-56px on desktop)
- Subtitle paragraph: Calm, warm-gray text
- Primary CTA: "Book a consultation" (button)
- Secondary CTA: "Learn about our approach" (link button)
- Trust indicators (3 inline badges below CTAs):
  - ✓ Specialist care
  - ✓ Personalised guidance
  - ✓ Discreet consultations

**Right column (image):**
- Elegant image placeholder (doctor/medical/aesthetic)
- Aspect ratio: roughly 4:5 (portrait-ish)
- Soft gradient or pattern background if no image
- Subtle gold accent line or frame

**Background:**
- Warm ivory (#FDFAF6)
- No overlay; light and open

**Copy suggestion (provided by user):**
```
Headline: "Specialist care with a personal, refined approach"
Subtitle: "Dr Sue-Liza Eta offers expert medical care across vascular surgery, medically guided weight loss and aesthetic medicine, with a focus on safety, clarity and individual attention."
CTA 1: "Book a consultation"
CTA 2: "Our approach"
Phone note: "Or call: [phone]" (optional, if config enabled)
```

**Trust indicators** (add to site config):
```php
'trust_indicators' => [
    'Specialist care',
    'Personalised guidance',
    'Discreet consultations',
],
```

---

### 3.3 — Services Section

**Section ID:** `#services`  
**Config keys:** `client-services.items` (3 items), `site.cta_primary`

**Layout:** 3-column grid on desktop, 1-column mobile

**Each service card:**
- Icon: Small SVG (or symbol) — not emoji
- Service name (h3)
- Description (short paragraph)
- Hover effect: subtle lift + shadow
- Optional inline CTA link (future enhancement; not in MVP)

**Services (from user spec):**
1. Vascular Surgery
2. Medical Weight Loss
3. Aesthetic Medicine

**Bottom CTA:** "Book a consultation" button (center)

**Copy notes:**
- Descriptions should be ~40-60 words
- Avoid hype; focus on what each service addresses and the approach
- Example for Medical Weight Loss: "Evidence-based weight management designed for lasting results. Personalised assessment, nutritional guidance, and medical monitoring throughout your journey."
- Example for Aesthetic Medicine: "Minimally invasive treatments for subtle, natural-looking results. Focused on enhancing what you already have, not transforming."

---

### 3.4 — About Section

**Section ID:** `#about`  
**Config keys:** `site.intro_long`, `images.about`, `site.cta_primary`, `site.business_type`

**Layout:** Two-column grid (image left, text right)

**Left column (image):**
- Placeholder frame (4:3 aspect ratio)
- Elegant rounded corners
- Soft background gradient if no image

**Right column (text):**
- Eyebrow: "About"
- Heading: "Yor trusted medical specialist" (or similar)
- Body: Friendly, personal, warm. Focus on:
  - Years of experience / credentials
  - Patient-first philosophy
  - Calm, personalised approach
  - Safety and clarity as pillars
- CTA button: "Book a consultation"

**Copy tone:** Personal but authoritative. "Dr Sue-Liza Eta brings [X] years of specialist expertise..."

---

### 3.5 — Approach / Patient Journey (NEW SECTION)

**Section ID:** `#approach`  
**Config keys:** `site.approach_title`, `site.approach_steps` (array of 4 steps)

**Layout:** Horizontal numbered steps on desktop (can add connecting line); vertical stack on mobile

**Each step card:**
- Number badge (1, 2, 3, 4) in gold accent color
- Title (h4)
- Description (short paragraph)
- Optional icon / visual

**Steps (from user spec):**
1. Initial consultation
2. Personal assessment
3. Treatment plan
4. Follow-up and guidance

**Copy:**
```php
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
```

**Section background:** Warm beige (#F5F1EB)

---

### 3.6 — Trust / Values Section

**Section ID:** `#trust`  
**Config keys:** `site.trust_points` (updated for medical values, not service points)

**Layout:** Grid (2 col desktop, 1 col mobile)

**Each value card:**
- Check mark / accent symbol (✓)
- Short statement (e.g., "Medical expertise", "Personalised care")
- Optional description line

**Values (new set for this client):**
```php
'trust_points' => [
    'Medical expertise — board-certified specialist with [X] years of experience',
    'Personalised care — every consultation, every plan tailored to you',
    'Clear communication — no jargon, no pressure, full transparency',
    'Safety-first approach — your wellbeing is the only priority',
],
```

**Section background:** White (#FDFAF6)

---

### 3.7 — CTA Banner (NEW SECTION)

**Section ID:** `#cta-banner`  
**Config keys:** `site.cta_banner_heading`, `site.cta_primary`

**Layout:** Centered, full width

**Content:**
- Heading (h2): "Ready to discuss your options?"
- Subheading (optional): "Get in touch for a confidential consultation."
- Button: "Book a consultation"

**Background:** Deep navy (#1C2B3A) or warm beige — will use navy for contrast

**Text color:** White (on navy)

**Section design:** Generous padding, minimal but premium feel

---

### 3.8 — Contact Section

**Section ID:** `#contact`  
**Config keys:** `site.phone`, `contact.email`, `contact.privacy_link`, `contact.form_request_types`

**Layout:** Two-column (info left, form right)

**Left column (contact info):**
- Heading: "Get in touch"
- Phone (clickable tel: link)
- Email (mailto: link)
- Address (optional; use placeholder or omit)
- Opening hours (if applicable; optional)
- Privacy link

**Right column (contact form):**
- Fields:
  1. Name (required)
  2. Email (required)
  3. Phone (required)
  4. Service / consultation type (select dropdown, required)
  5. Message (textarea, required)
  6. Privacy consent checkbox (required)
- Submit button: "Send inquiry"
- Note: Form is visual only; mail routing added in phase 2

**Form request types (from user, English):**
```php
'form_request_types' => [
    'Vascular Surgery consultation',
    'Medical Weight Loss consultation',
    'Aesthetic Medicine consultation',
    'General inquiry',
],
```

**Background:** Warm beige (#F5F1EB)

**Privacy consent copy:**
```
"I agree that my information will be used to respond to my inquiry. [Privacy Policy link]"
```

---

### 3.9 — Footer

**Location:** Sticky to bottom (flexbox: main.has-fixed-nav grows)

**Content (three columns on desktop, stacked mobile):**
1. Business name + address + phone + email
2. Navigation links (repeated from header)
3. Opening hours (if applicable) + Privacy link

**Background:** Deep navy (#1C2B3A)  
**Text:** White, muted  
**Copy:** From `config('site.footer_text')`, `config('site.name')`, etc.

---

### 3.10 — Sections Control (config/site.php)

**Enabled:**
```php
'sections' => [
    'hero' => true,
    'services' => true,
    'about' => true,
    'approach' => true,
    'trust' => true,
    'cta_banner' => true,
    'contact' => true,
    'gallery' => false,      // disabled
    'location' => false,     // disabled
],
```

---

## 4. Config File Structure

### config/site.php

```php
return [
    // Basic info
    'name'          => 'Dr Sue-Liza Eta',
    'short_name'    => 'Dr Sue-Liza',
    'tagline'       => 'Specialist care with a personal, refined approach',
    'intro_short'   => 'Dr Sue-Liza Eta offers expert medical care across vascular surgery, medically guided weight loss and aesthetic medicine, with a focus on safety, clarity and individual attention.',
    'intro_long'    => '[Bio text about the doctor]',
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
    'phone'   => '+1 (555) 000-0000', // placeholder
    'address' => '[City, State]',
    'city'    => '[City]',
    'region'  => '[State]',

    // Opening hours (optional; can omit for medical office)
    'opening_hours' => [
        'Monday – Friday' => '09:00 – 17:00',
        'Saturday'        => 'By appointment',
        'Sunday'          => 'Closed',
    ],

    // Trust indicators (hero section)
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
        'Medical expertise — board-certified specialist',
        'Personalised care — tailored to your unique needs',
        'Clear communication — transparent, no jargon',
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

### config/theme.php

```php
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

### config/seo.php

```php
return [
    'title'       => 'Dr Sue-Liza Eta — Medical Specialist | Vascular Surgery, Medical Weight Loss, Aesthetic Medicine',
    'description' => 'Expert medical care from Dr Sue-Liza Eta. Specialising in vascular surgery, medically guided weight loss and aesthetic medicine. Safe, personalised, discreet.',
    'keywords'    => ['vascular surgery', 'medical weight loss', 'aesthetic medicine', 'specialist consultation'],

    'og_title'       => 'Dr Sue-Liza Eta — Medical Specialist',
    'og_description' => 'Specialist care with a personal, refined approach.',
    'og_image'       => '/assets/client/hero.jpg',
    'og_type'        => 'website',
    'canonical_url'  => '',

    'noindex' => false,
];
```

### config/contact.php

```php
return [
    'phone'        => '+1 (555) 000-0000',
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

### config/client-services.php

```php
return [
    'items' => [
        [
            'name'        => 'Vascular Surgery',
            'description' => 'Specialist surgical care for vascular conditions. Personalised assessment, advanced techniques, expert follow-up care.',
            'icon'        => 'vascular',  // SVG key (not emoji)
        ],
        [
            'name'        => 'Medical Weight Loss',
            'description' => 'Evidence-based weight management with medical supervision. Nutritional guidance, personalised monitoring, sustainable results.',
            'icon'        => 'weight',
        ],
        [
            'name'        => 'Aesthetic Medicine',
            'description' => 'Minimally invasive treatments for natural-looking results. Subtle enhancements focused on what you already have.',
            'icon'        => 'aesthetic',
        ],
    ],
];
```

### config/images.php

```php
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

---

## 5. Blade Views — New & Modified

### New Views

1. **`resources/views/sections/approach.blade.php`**
   - Patient journey / 4-step approach section
   - Conditional rendering based on `config('site.sections.approach')`

2. **`resources/views/sections/cta-banner.blade.php`**
   - Simple CTA strip (heading + button)
   - Navy background, white text
   - Conditional rendering based on `config('site.sections.cta_banner')`

### Modified Views

1. **`resources/views/layouts/client.blade.php`**
   - Change `lang="nl"` to `lang="en"`

2. **`resources/views/pages/home.blade.php`**
   - Add `@include('sections.approach')` after about
   - Add `@include('sections.cta-banner')` before contact

3. **`resources/views/sections/hero.blade.php`**
   - Complete redesign: split layout (text left, image right)
   - Add trust indicators below CTAs
   - Mobile: single column with image as visual block

4. **`resources/views/sections/services.blade.php`**
   - Support for SVG/icon keys (not emoji)
   - 3-column layout (overrides current 4-column for this client)

5. **`resources/views/sections/contact.blade.php`**
   - English labels and copy
   - Update form request types

6. **`resources/views/sections/trust.blade.php`**
   - Minor styling tweaks for value cards

---

## 6. CSS Additions

All additions to `resources/css/client-site.css` (maintaining existing layers and structure).

### New Components

1. **Hero split layout**
   - `.hero-doctor` — container
   - `.hero-doctor-content` — text column
   - `.hero-doctor-image` — image column
   - `.hero-trust-indicators` — badge row
   - `.hero-trust-badge` — individual badge

2. **Approach section**
   - `.approach-section` — container
   - `.approach-steps-grid` — horizontal steps layout
   - `.step-card` — individual step
   - `.step-number` — numbered badge
   - Media query for mobile (vertical stack)

3. **CTA banner**
   - `.cta-banner` — full-width container
   - `.cta-banner-content` — centered inner
   - `.cta-banner-heading` — large heading
   - `.cta-banner-subheading` — optional secondary text

4. **Scroll reveal animation**
   - `.reveal` — base class for reveal effect
   - `.reveal.is-visible` — animation trigger state
   - Animation: fade-up + opacity transition

5. **Services grid override**
   - Override `.services-grid` columns from 4 to 3

### Color & Theme

- All colors use CSS variables from `config/theme.php`
- No hardcoded color values in CSS
- Hover states use `filter: brightness()` or opacity shifts

---

## 7. JavaScript Additions

### app.js

Add simple Intersection Observer (~20 lines):
- Watch for `[data-reveal]` elements
- Add `.is-visible` class when element enters viewport
- Trigger CSS transition/animation
- No external libraries needed

Example usage in Blade:
```blade
<div class="service-card" data-reveal>...</div>
```

---

## 8. Testing

### tests/Feature/HomepageTest.php

Update assertions:
- `assertSee(config('site.name'))` — now "Dr Sue-Liza Eta"
- `assertSee(config('site.phone'))` — updated placeholder
- Gallery section still disabled (test passes)
- Approach section enabled (new section renders)
- CTA banner enabled (new section renders)

Add new tests:
- Approach section renders when enabled
- CTA banner renders when enabled
- Trust indicators display in hero

---

## 9. Accessibility

- Semantic HTML (h1, h2, h3 hierarchy)
- Form labels with proper `for` attributes
- ARIA labels on icon-only elements
- Contrast ratio ≥ 4.5:1 for all text
- Focus states on interactive elements
- Mobile nav `aria-expanded`, `aria-hidden` properly managed
- Image placeholders have `role="img"` and `aria-label`

---

## 10. Performance & Optimization

- Vite builds with tree-shaking
- CSS layers prevent bloat
- Images use background-image (degrade gracefully without real photos)
- No render-blocking scripts
- Minimal JS (only nav toggle + scroll reveal)
- Lazy-load images when implemented

---

## 11. Medical / Ethical Considerations

**Copy guidelines:**
- No guaranteed claims ("guaranteed results", "100% success")
- No exaggeration ("instant", "revolutionary", "magic")
- Use careful qualifiers: "may help", "can support", "evidence-based"
- Focus on process, not outcome promises
- "Medically guided", "personalised", "consultation-based", "patient-centred"

**Examples:**
- ❌ "Guaranteed weight loss results"
- ✅ "Evidence-based weight management with medical guidance"
- ❌ "Instant rejuvenation"
- ✅ "Subtle, natural-looking enhancements"
- ❌ "Quick fix for vascular issues"
- ✅ "Specialist surgical care personalised to your needs"

---

## 12. Future Enhancements (Phase 2+)

- Contact form backend integration (mail routing, validation)
- Appointment booking system (calendar integration)
- Testimonials / case studies section
- Blog / educational content
- Gallery of real images (replace placeholders)
- Newsletter signup
- Live chat / support widget
- SEO schema (MedicalBusiness, LocalBusiness)

---

## 13. Project Deliverables

- Config files updated (site, theme, seo, contact, services, images)
- Blade views created/modified (hero redesign, new approach/cta-banner sections)
- CSS additions (hero split layout, approach steps, cta banner, reveal animations)
- JS additions (scroll reveal observer)
- Tests updated
- All tests pass
- Build succeeds
- No hardcoded strings in templates

