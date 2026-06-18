# SEO Foundation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a clean SEO foundation — sitemap.xml, robots.txt, 8 local SEO landing pages, per-page meta tags, internal links and footer SEO links — to the existing Laravel website for Dr Sue-Liza Eta.

**Architecture:** A single `SeoPageController` serves all 8 landing pages using one reusable Blade template (`pages/seo-landing`). Page data lives in `config/seo-pages.php`. The layout is updated to accept a `$seo` view variable with fallback to the existing `config('seo.*')` system so existing pages are not broken. The sitemap is a Laravel route returning an XML Blade view.

**Tech Stack:** Laravel 11, Blade, Tailwind CSS (via `client-site.css` conventions), PHP 8.x. No new packages required.

## Global Constraints

- APP_URL in production is `https://drsuelizaeta.be`
- All URLs in sitemap must be absolute HTTPS using `config('app.url')`
- Doctoranytime URL: `config('contact.doctoranytime_url')` (already in `config/contact.php`)
- Contact anchor: `/#contact-form`
- Tone: professional, medically careful — "may help", "can be discussed", "may be suitable", "a consultation is needed"
- Forbidden phrases: "guaranteed results", "best doctor", "permanent solution", "risk-free treatment", "before/after promises"
- Every SEO page must include the disclaimer: "This page is for general information only and does not replace a medical consultation. A personal consultation is needed to assess suitability, treatment options and possible risks."
- Do NOT commit automatically
- CSS class conventions follow the existing `client-site.css` design system (classes like `client-section`, `client-container`, `section-eyebrow`, `section-title`, `section-body`)

---

## File Map

| Action | File | Responsibility |
|--------|------|----------------|
| Modify | `resources/views/layouts/client.blade.php` | Accept `$seo` view variable with config fallbacks |
| Create | `config/seo-pages.php` | All 8 page data (content, meta, related links) |
| Create | `app/Http/Controllers/SeoPageController.php` | Resolve slug → page data → view |
| Create | `resources/views/pages/seo-landing.blade.php` | Reusable SEO landing page template |
| Create | `resources/views/sitemap.blade.php` | XML sitemap view |
| Modify | `routes/web.php` | Add 8 SEO page routes + sitemap route |
| Modify | `public/robots.txt` | Add Sitemap directive |
| Modify | `resources/views/partials/footer.blade.php` | Add "Treatments & Locations" SEO link section |

---

### Task 1: Update layout to accept per-page `$seo` variable

**Files:**
- Modify: `resources/views/layouts/client.blade.php` (lines 15–29)

**Why:** The layout currently reads SEO values directly from `config('seo.*')`. SEO landing pages need per-page titles, descriptions and canonical URLs. This update makes the layout check a `$seo` view variable first, falling back to config so existing pages (home, privacy, legal) are not affected.

- [ ] **Step 1: Read the current layout**

Open `resources/views/layouts/client.blade.php` and confirm lines 15–29 contain the meta block.

- [ ] **Step 2: Replace the meta block**

Replace this block (lines 15–29):

```blade
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
```

With this block:

```blade
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
```

- [ ] **Step 3: Verify the homepage still renders**

```bash
php artisan route:list
```

Expected: routes for `/`, `/privacy-policy`, `/legal-notice`, `/contact` still appear without errors.

---

### Task 2: Create `config/seo-pages.php` with all 8 pages

**Files:**
- Create: `config/seo-pages.php`

**Why:** Centralises all SEO page data. The controller and sitemap both read from this config, keeping everything DRY. Page content is stored here so the Blade template stays logic-free.

- [ ] **Step 1: Create `config/seo-pages.php` with the following content**

```php
<?php

$baseUrl = config('app.url', 'https://drsuelizaeta.be');

return [

    'botox-woluwe-saint-pierre' => [
        'slug'             => 'botox-woluwe-saint-pierre',
        'category'         => 'aesthetic',
        'seo_title'        => 'Botox Woluwe-Saint-Pierre | Dr Sue-Liza Eta – Aesthetic Medicine',
        'meta_description' => 'Dr Sue-Liza Eta offers Botox consultations at Stockel Medical Center in Woluwe-Saint-Pierre, Brussels. Natural-looking results through a personalised, medically guided approach.',
        'og_title'         => 'Botox in Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'og_description'   => 'Personalised Botox consultations at Stockel Medical Center, Woluwe-Saint-Pierre, Brussels.',
        'h1'               => 'Botox in Woluwe-Saint-Pierre',
        'eyebrow'          => 'Aesthetic Medicine · Woluwe-Saint-Pierre',
        'intro'            => 'Dr Sue-Liza Eta offers Botox consultations at the Stockel Medical Center in Woluwe-Saint-Pierre, Brussels. As a medical doctor with experience in aesthetic medicine, she takes a careful, individual approach — focused on natural-looking results rather than dramatic changes. Every consultation begins with a thorough discussion of your concerns and expectations.',
        'main_heading'     => 'A medical approach to Botox',
        'main_body'        => 'Botox (botulinum toxin) is one of the most widely used aesthetic treatments. When administered carefully by a qualified medical professional, it may help reduce the appearance of dynamic wrinkles — the lines that form through repeated facial expressions such as frowning, squinting or smiling. Common areas include the forehead, the area between the brows and around the eyes.

At Dr Sue-Liza Eta\'s practice, Botox is always approached from a medical perspective. The aim is not to freeze expression but to allow the face to move more comfortably, with subtlety. Results, duration and suitability vary from person to person — which is why a personal consultation is always the starting point.

Botox is a prescription medicine in Belgium and can only be administered by a registered medical professional following an in-person assessment.',
        'consultation_heading' => 'What to expect during a consultation',
        'consultation_body'    => 'During your first consultation, Dr Sue-Liza Eta will listen to your concerns, assess the areas you wish to discuss and review your medical history. She will explain what Botox may or may not achieve, what the procedure involves and what to expect afterwards. If a treatment is agreed upon, it may take place on the same visit or a follow-up appointment — depending on your individual situation. There is no pressure to proceed, and all questions are welcome.',
        'suitability_heading'  => 'Who this may be suitable for',
        'suitability_points'   => [
            'Adults in good general health who wish to discuss facial aesthetic concerns',
            'Those seeking a subtle, natural-looking result rather than a dramatic change',
            'People looking for a medically guided approach with time for questions',
            'Suitability is always assessed during a personal consultation — not every treatment is appropriate for every person',
        ],
        'related_pages' => [
            ['label' => 'Botox in Stockel',                           'url' => '/botox-stockel'],
            ['label' => 'Aesthetic Medicine in Woluwe-Saint-Pierre',  'url' => '/aesthetic-medicine-woluwe-saint-pierre'],
            ['label' => 'Hyaluronic Acid Fillers in Woluwe-Saint-Pierre', 'url' => '/hyaluronic-acid-fillers-woluwe-saint-pierre'],
        ],
    ],

    'botox-stockel' => [
        'slug'             => 'botox-stockel',
        'category'         => 'aesthetic',
        'seo_title'        => 'Botox Stockel | Dr Sue-Liza Eta – Aesthetic Medicine Brussels',
        'meta_description' => 'Botox consultations at Stockel Medical Center with Dr Sue-Liza Eta. A discreet, personalised approach to facial aesthetics in the heart of Stockel, Brussels.',
        'og_title'         => 'Botox in Stockel | Dr Sue-Liza Eta',
        'og_description'   => 'Personalised Botox consultations with Dr Sue-Liza Eta at Stockel Medical Center, Brussels.',
        'h1'               => 'Botox in Stockel',
        'eyebrow'          => 'Aesthetic Medicine · Stockel, Brussels',
        'intro'            => 'Stockel Medical Center is where Dr Sue-Liza Eta sees patients for Botox consultations. Located in the Stockel area of Woluwe-Saint-Pierre, the practice offers a calm, discreet setting for aesthetic medicine discussions. Dr Eta\'s approach is medically grounded — she takes time to understand your goals and to assess whether a treatment may be appropriate for you.',
        'main_heading'     => 'Botox consultation at Stockel Medical Center',
        'main_body'        => 'Botox (botulinum toxin) treatments are used in aesthetic medicine to address dynamic wrinkles — lines that appear with movement, such as forehead lines, frown lines between the brows and lines around the eyes. The effect is not permanent, and results differ between individuals.

Dr Sue-Liza Eta offers Botox consultations at her Stockel practice as part of a broader range of aesthetic medicine services. Her approach prioritises safety and individual suitability above all else. Treatments are never applied without a prior in-person assessment, and the aim is always a natural result that complements your appearance rather than altering it significantly.

As a medical doctor, Dr Eta is qualified to prescribe and administer botulinum toxin in accordance with Belgian medical regulations.',
        'consultation_heading' => 'What to expect during a consultation',
        'consultation_body'    => 'Your Botox consultation at the Stockel Medical Center begins with a relaxed conversation. Dr Sue-Liza Eta will ask about your concerns, your medical background and any previous aesthetic treatments you may have had. She will assess the areas you have in mind and explain what may or may not be achievable. You will have the opportunity to ask all your questions before any decision is made. No treatment takes place without your informed agreement.',
        'suitability_heading'  => 'Who this may be suitable for',
        'suitability_points'   => [
            'Adults seeking a medical consultation about facial aesthetic concerns',
            'Those looking for a discreet, professional practice close to Woluwe-Saint-Pierre and Brussels',
            'People who value a calm, unhurried consultation environment',
            'Suitability is determined on a case-by-case basis during your personal assessment',
        ],
        'related_pages' => [
            ['label' => 'Botox in Woluwe-Saint-Pierre',               'url' => '/botox-woluwe-saint-pierre'],
            ['label' => 'Aesthetic Medicine in Woluwe-Saint-Pierre',  'url' => '/aesthetic-medicine-woluwe-saint-pierre'],
            ['label' => 'Hyaluronic Acid Fillers in Woluwe-Saint-Pierre', 'url' => '/hyaluronic-acid-fillers-woluwe-saint-pierre'],
        ],
    ],

    'aesthetic-medicine-woluwe-saint-pierre' => [
        'slug'             => 'aesthetic-medicine-woluwe-saint-pierre',
        'category'         => 'aesthetic',
        'seo_title'        => 'Aesthetic Medicine Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'meta_description' => 'Dr Sue-Liza Eta offers aesthetic medicine consultations in Woluwe-Saint-Pierre. Botox, fillers and skin quality treatments with a natural, medically careful approach.',
        'og_title'         => 'Aesthetic Medicine in Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'og_description'   => 'Aesthetic medicine consultations at Stockel Medical Center, Woluwe-Saint-Pierre — Botox, fillers and more.',
        'h1'               => 'Aesthetic Medicine in Woluwe-Saint-Pierre',
        'eyebrow'          => 'Aesthetic Medicine · Woluwe-Saint-Pierre',
        'intro'            => 'Dr Sue-Liza Eta offers aesthetic medicine consultations at the Stockel Medical Center in Woluwe-Saint-Pierre, Brussels. Her approach to aesthetic medicine is rooted in her medical background — she focuses on safe, considered treatments that may help patients feel more comfortable and confident in their appearance. The emphasis is always on subtlety, safety and individual assessment.',
        'main_heading'     => 'Aesthetic medicine with a medical foundation',
        'main_body'        => 'Aesthetic medicine covers a range of non-surgical treatments aimed at improving appearance and skin quality. At Dr Sue-Liza Eta\'s practice, this includes consultations around Botox (botulinum toxin), hyaluronic acid fillers and skin quality concerns.

The practice does not offer one-size-fits-all solutions. Each patient is assessed individually, and Dr Eta takes time to understand not only what you are hoping to address but also your broader health picture. Some treatments may not be appropriate for every person, which is why a medical consultation always comes first.

Aesthetic medicine at this practice is guided by the principle that results should look natural and that your wellbeing is the only priority — not a particular treatment or outcome.',
        'consultation_heading' => 'What to expect during a consultation',
        'consultation_body'    => 'During an aesthetic medicine consultation, Dr Sue-Liza Eta will listen to your concerns, review your health background and discuss what options may be worth considering. She will be honest about what treatments can and cannot achieve, what the procedure involves and what recovery or aftercare typically looks like. If a treatment is agreed upon, she will ensure you have time to consider it without pressure.',
        'suitability_heading'  => 'Who this may be suitable for',
        'suitability_points'   => [
            'Adults who would like to discuss aesthetic concerns with a qualified medical professional',
            'Those interested in Botox, hyaluronic acid fillers or skin quality options',
            'People who prefer a considered, unhurried approach over a high-volume aesthetic clinic',
            'Individual suitability is always assessed — not every treatment suits every person or situation',
        ],
        'related_pages' => [
            ['label' => 'Botox in Woluwe-Saint-Pierre',                   'url' => '/botox-woluwe-saint-pierre'],
            ['label' => 'Botox in Stockel',                               'url' => '/botox-stockel'],
            ['label' => 'Hyaluronic Acid Fillers in Woluwe-Saint-Pierre', 'url' => '/hyaluronic-acid-fillers-woluwe-saint-pierre'],
        ],
    ],

    'hyaluronic-acid-fillers-woluwe-saint-pierre' => [
        'slug'             => 'hyaluronic-acid-fillers-woluwe-saint-pierre',
        'category'         => 'aesthetic',
        'seo_title'        => 'Hyaluronic Acid Fillers Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'meta_description' => 'Hyaluronic acid filler consultations with Dr Sue-Liza Eta at Stockel Medical Center, Woluwe-Saint-Pierre. Subtle, natural-looking facial volume restoration.',
        'og_title'         => 'Hyaluronic Acid Fillers in Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'og_description'   => 'Filler consultations at Stockel Medical Center, Woluwe-Saint-Pierre — a natural, medically guided approach.',
        'h1'               => 'Hyaluronic Acid Fillers in Woluwe-Saint-Pierre',
        'eyebrow'          => 'Aesthetic Medicine · Woluwe-Saint-Pierre',
        'intro'            => 'Dr Sue-Liza Eta offers hyaluronic acid filler consultations at the Stockel Medical Center in Woluwe-Saint-Pierre, Brussels. As a medical doctor, she approaches fillers with care and precision — the goal is always a natural result that enhances your features without looking overdone. Each consultation includes a thorough assessment to determine whether fillers may be suitable for you and, if so, which approach makes the most sense.',
        'main_heading'     => 'Hyaluronic acid fillers — what they are and how they work',
        'main_body'        => 'Hyaluronic acid is a substance that occurs naturally in the body. When used as a dermal filler, it may help restore volume in areas where it has been lost through ageing, or add subtle definition to features such as the lips or cheeks. The effects are not permanent — hyaluronic acid is gradually broken down by the body over time.

Common areas that may be considered include the cheeks, nasolabial folds, lips and under-eye area. However, not every area or concern is suitable for filler treatment, and the assessment always comes first.

Dr Sue-Liza Eta uses hyaluronic acid products approved for medical use. Treatments are only carried out after a thorough in-person consultation and with your full, informed agreement.',
        'consultation_heading' => 'What to expect during a consultation',
        'consultation_body'    => 'During a filler consultation, Dr Eta will assess your facial structure, listen to what you are hoping to address and discuss realistic expectations. She will explain the areas that may benefit from treatment, the products and techniques she would consider and what the treatment experience typically involves. She will also cover aftercare, what to watch for and when to follow up. No treatment proceeds without your clear agreement.',
        'suitability_heading'  => 'Who this may be suitable for',
        'suitability_points'   => [
            'Adults who wish to discuss facial volume or contour concerns with a medical professional',
            'Those who have researched fillers and want an honest, unhurried assessment',
            'People looking for subtle, natural-looking results rather than dramatic changes',
            'Suitability depends on individual health, anatomy and expectations — this is assessed in person',
        ],
        'related_pages' => [
            ['label' => 'Aesthetic Medicine in Woluwe-Saint-Pierre',  'url' => '/aesthetic-medicine-woluwe-saint-pierre'],
            ['label' => 'Botox in Woluwe-Saint-Pierre',               'url' => '/botox-woluwe-saint-pierre'],
            ['label' => 'Botox in Stockel',                           'url' => '/botox-stockel'],
        ],
    ],

    'medical-weight-loss-woluwe-saint-pierre' => [
        'slug'             => 'medical-weight-loss-woluwe-saint-pierre',
        'category'         => 'weight_loss',
        'seo_title'        => 'Medical Weight Loss Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'meta_description' => 'Doctor-supervised weight loss consultations with Dr Sue-Liza Eta in Woluwe-Saint-Pierre. A personalised, health-focused approach to medically guided weight management.',
        'og_title'         => 'Medical Weight Loss in Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'og_description'   => 'Medically guided weight loss consultations at Stockel Medical Center, Woluwe-Saint-Pierre.',
        'h1'               => 'Medical Weight Loss in Woluwe-Saint-Pierre',
        'eyebrow'          => 'Medical Weight Loss · Woluwe-Saint-Pierre',
        'intro'            => 'Dr Sue-Liza Eta offers medically guided weight loss consultations at the Stockel Medical Center in Woluwe-Saint-Pierre, Brussels. Her approach is grounded in medicine and focused on your overall health — not just a number on a scale. She works with patients who have struggled with weight management and are looking for a structured, doctor-supervised approach tailored to their individual situation.',
        'main_heading'     => 'A doctor-supervised approach to weight management',
        'main_body'        => 'Medical weight loss involves a structured assessment of the factors contributing to weight gain or difficulty losing weight. These may include metabolic factors, hormonal considerations, lifestyle patterns and medical history. Unlike general weight loss programmes, a medical consultation looks at the whole picture.

Dr Sue-Liza Eta takes time to understand your health background, your goals and the challenges you have faced. Based on this assessment, she may be able to discuss options that could support your weight management journey — which may include dietary guidance, medical monitoring or, where clinically appropriate, medication. All options are discussed openly and honestly.

There are no shortcuts or quick fixes. The aim is a sustainable, health-focused approach that supports you in the long term.',
        'consultation_heading' => 'What to expect during a consultation',
        'consultation_body'    => 'Your first consultation will involve a detailed discussion of your health history, current situation and goals. Dr Eta will ask about previous weight management efforts, any relevant medical conditions and your lifestyle. She may request blood tests or other investigations if these would help inform the assessment. From there, she will discuss what options may be worth considering in your individual case — with clarity and without judgment.',
        'suitability_heading'  => 'Who this may be suitable for',
        'suitability_points'   => [
            'Adults who have struggled with weight management and are looking for medical support',
            'Those with a health condition that may be related to or affected by weight',
            'People who want a personalised, doctor-led approach rather than a generic programme',
            'Suitability and the appropriate approach depend on your individual health picture, assessed in consultation',
        ],
        'related_pages' => [
            ['label' => 'Book a consultation via Doctoranytime', 'url' => config('contact.doctoranytime_url'), 'external' => true],
            ['label' => 'Contact the practice',                 'url' => '/#contact-form'],
        ],
    ],

    'vascular-surgeon-woluwe-saint-pierre' => [
        'slug'             => 'vascular-surgeon-woluwe-saint-pierre',
        'category'         => 'vascular',
        'seo_title'        => 'Vascular Surgeon Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'meta_description' => 'Dr Sue-Liza Eta is a vascular surgeon practicing at Stockel Medical Center in Woluwe-Saint-Pierre. Specialist vascular care with a personalised, attentive approach.',
        'og_title'         => 'Vascular Surgeon in Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'og_description'   => 'Specialist vascular surgery consultations at Stockel Medical Center, Woluwe-Saint-Pierre, Brussels.',
        'h1'               => 'Vascular Surgeon in Woluwe-Saint-Pierre',
        'eyebrow'          => 'Vascular Surgery · Woluwe-Saint-Pierre',
        'intro'            => 'Dr Sue-Liza Eta is a medical doctor and vascular surgeon practicing at the Stockel Medical Center in Woluwe-Saint-Pierre, Brussels. She offers specialist consultations for patients with vascular concerns — including varicose veins, circulation issues and other conditions affecting the veins and blood vessels. Her approach combines specialist expertise with a calm, attentive consultation style.',
        'main_heading'     => 'Vascular surgery consultations in Woluwe-Saint-Pierre',
        'main_body'        => 'Vascular surgery is a medical specialty focused on conditions affecting the blood vessels — including veins and arteries throughout the body. Common reasons patients seek a vascular consultation include varicose veins, spider veins (telangiectasias), leg swelling, heaviness or discomfort related to venous insufficiency, and concerns about circulation.

At the Stockel Medical Center, Dr Sue-Liza Eta offers specialist vascular consultations for patients in Woluwe-Saint-Pierre and the wider Brussels area. Each consultation begins with a careful assessment of your symptoms, medical history and, where appropriate, diagnostic imaging or investigation. Treatment options — where applicable — are discussed clearly and without pressure.

Not every vascular symptom requires intervention. Sometimes reassurance and lifestyle advice are the most appropriate approach. Dr Eta will be honest with you about what she finds and what options, if any, may be worth considering.',
        'consultation_heading' => 'What to expect during a vascular consultation',
        'consultation_body'    => 'During your vascular consultation, Dr Eta will take a detailed history of your symptoms and relevant medical background. She will carry out a clinical examination of the affected area. Depending on what she finds, she may recommend further investigation such as a duplex ultrasound scan. She will then discuss her findings with you and explain what, if anything, she recommends. All options are presented clearly so you can make an informed decision.',
        'suitability_heading'  => 'Who this may be suitable for',
        'suitability_points'   => [
            'Adults with concerns about varicose veins, spider veins or leg vein discomfort',
            'Those who have been advised to see a vascular specialist by their GP',
            'Patients experiencing leg heaviness, swelling or circulation-related symptoms',
            'Anyone who would like a specialist opinion on a vascular concern — suitability for treatment is always assessed in person',
        ],
        'related_pages' => [
            ['label' => 'Varicose Veins in Woluwe-Saint-Pierre',  'url' => '/varicose-veins-woluwe-saint-pierre'],
            ['label' => 'Sclerotherapy in Woluwe-Saint-Pierre',   'url' => '/sclerotherapy-woluwe-saint-pierre'],
        ],
    ],

    'varicose-veins-woluwe-saint-pierre' => [
        'slug'             => 'varicose-veins-woluwe-saint-pierre',
        'category'         => 'vascular',
        'seo_title'        => 'Varicose Veins Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'meta_description' => 'Varicose vein consultations with Dr Sue-Liza Eta at Stockel Medical Center, Woluwe-Saint-Pierre. Specialist assessment and personalised treatment options.',
        'og_title'         => 'Varicose Veins Consultation in Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'og_description'   => 'Specialist varicose vein consultations at Stockel Medical Center, Woluwe-Saint-Pierre.',
        'h1'               => 'Varicose Veins Consultation in Woluwe-Saint-Pierre',
        'eyebrow'          => 'Vascular Surgery · Woluwe-Saint-Pierre',
        'intro'            => 'Dr Sue-Liza Eta offers specialist consultations for varicose veins at the Stockel Medical Center in Woluwe-Saint-Pierre, Brussels. Varicose veins are a common concern that can range from a purely cosmetic issue to a source of significant discomfort. A specialist assessment helps clarify the nature and extent of the condition and what, if any, treatment options may be appropriate.',
        'main_heading'     => 'Understanding varicose veins',
        'main_body'        => 'Varicose veins develop when the valves within a vein stop working effectively, causing blood to pool and the vein to enlarge. They most commonly appear in the legs and may look blue or purple, bulging or twisted beneath the skin. Some people have no symptoms beyond their appearance; others may experience aching, heaviness, swelling or skin changes around the ankles.

Not all varicose veins require treatment. In some cases, lifestyle measures and compression hosiery may be all that is recommended. Where treatment is discussed, options may include sclerotherapy for smaller veins or other interventions for larger varicose veins — depending on the clinical picture.

Dr Sue-Liza Eta will carry out a thorough assessment to determine the nature of your veins and whether any treatment may be appropriate. She will explain her findings clearly and discuss any options with you honestly.',
        'consultation_heading' => 'What to expect during a consultation',
        'consultation_body'    => 'At your first appointment, Dr Eta will ask about your symptoms, how long you have had them and your relevant medical history. She will examine the affected areas and may organise a duplex ultrasound scan to assess the veins in more detail. Following assessment, she will explain what she has found, whether treatment may be worth discussing and, if so, what the options might be. You will have time to ask questions and consider your choices.',
        'suitability_heading'  => 'Who this may be suitable for',
        'suitability_points'   => [
            'Adults experiencing varicose veins, leg aching, swelling or heaviness',
            'Those referred for a specialist vascular opinion by their GP',
            'People who would like clarity on whether their varicose veins require attention',
            'Treatment options depend on clinical assessment — not every varicose vein requires intervention',
        ],
        'related_pages' => [
            ['label' => 'Vascular Surgeon in Woluwe-Saint-Pierre',  'url' => '/vascular-surgeon-woluwe-saint-pierre'],
            ['label' => 'Sclerotherapy in Woluwe-Saint-Pierre',     'url' => '/sclerotherapy-woluwe-saint-pierre'],
        ],
    ],

    'sclerotherapy-woluwe-saint-pierre' => [
        'slug'             => 'sclerotherapy-woluwe-saint-pierre',
        'category'         => 'vascular',
        'seo_title'        => 'Sclerotherapy Woluwe-Saint-Pierre | Dr Sue-Liza Eta – Vascular Treatment',
        'meta_description' => 'Sclerotherapy consultations with Dr Sue-Liza Eta at Stockel Medical Center, Woluwe-Saint-Pierre. Specialist treatment for spider veins and smaller varicose veins.',
        'og_title'         => 'Sclerotherapy in Woluwe-Saint-Pierre | Dr Sue-Liza Eta',
        'og_description'   => 'Sclerotherapy consultations at Stockel Medical Center, Woluwe-Saint-Pierre — specialist vascular treatment.',
        'h1'               => 'Sclerotherapy in Woluwe-Saint-Pierre',
        'eyebrow'          => 'Vascular Surgery · Woluwe-Saint-Pierre',
        'intro'            => 'Dr Sue-Liza Eta offers sclerotherapy consultations at the Stockel Medical Center in Woluwe-Saint-Pierre, Brussels. Sclerotherapy is a vascular procedure used to treat spider veins and certain smaller varicose veins. As a vascular surgeon and medical doctor, Dr Eta brings specialist knowledge to the assessment and discussion of this treatment — ensuring that it is appropriate for your specific situation before proceeding.',
        'main_heading'     => 'What is sclerotherapy?',
        'main_body'        => 'Sclerotherapy involves injecting a solution directly into the affected vein. This causes the vein wall to become irritated, close and gradually fade from view. It is most commonly used for spider veins (telangiectasias) and reticular veins — the smaller, thread-like vessels that can appear on the legs.

The procedure is carried out in a clinical setting and typically requires multiple sessions, depending on the extent of the veins being treated. Results are not immediate — veins generally fade over several weeks following treatment.

Sclerotherapy is not suitable for all types of varicose veins. Larger or deeper veins may require a different approach, which is why a thorough vascular assessment always comes first. Dr Eta will assess whether sclerotherapy is likely to be appropriate for your situation and explain the realistic expectations, possible side effects and what aftercare typically involves.',
        'consultation_heading' => 'What to expect during a consultation',
        'consultation_body'    => 'Your sclerotherapy consultation will begin with an assessment of the veins you wish to discuss. Dr Eta will examine the affected areas, ask about your symptoms and health background and determine whether sclerotherapy may be a suitable option. She may recommend a duplex ultrasound scan to rule out underlying venous insufficiency before proceeding. If treatment is agreed upon, she will explain how it works, what the sessions involve and what you can expect during the healing period.',
        'suitability_heading'  => 'Who this may be suitable for',
        'suitability_points'   => [
            'Adults with spider veins or smaller varicose veins who wish to discuss treatment',
            'Those in good general health, without significant underlying venous disease (assessed in consultation)',
            'People who are not pregnant or breastfeeding (contraindicated)',
            'Suitability is always confirmed through a personal assessment — sclerotherapy is not appropriate in every case',
        ],
        'related_pages' => [
            ['label' => 'Varicose Veins in Woluwe-Saint-Pierre',    'url' => '/varicose-veins-woluwe-saint-pierre'],
            ['label' => 'Vascular Surgeon in Woluwe-Saint-Pierre',  'url' => '/vascular-surgeon-woluwe-saint-pierre'],
        ],
    ],

];
```

- [ ] **Step 2: Verify the file was saved**

```bash
php artisan tinker --execute="dd(array_keys(config('seo-pages')));"
```

Expected output: array with 8 keys matching the 8 slugs.

---

### Task 3: Create `SeoPageController`

**Files:**
- Create: `app/Http/Controllers/SeoPageController.php`

**Interfaces:**
- Consumes: `config('seo-pages')[$slug]` — the page data array from Task 2
- Produces: view `pages.seo-landing` with variables `$page` (array) and `$seo` (array)

- [ ] **Step 1: Create `app/Http/Controllers/SeoPageController.php`**

```php
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
```

- [ ] **Step 2: Verify class loads**

```bash
php artisan about
```

Expected: No errors about missing or misconfigured classes.

---

### Task 4: Create `resources/views/pages/seo-landing.blade.php`

**Files:**
- Create: `resources/views/pages/seo-landing.blade.php`

**Interfaces:**
- Consumes: `$page` (array from `config/seo-pages.php`) and `$seo` (passed from `SeoPageController`)
- The layout uses `$seo` via Task 1's update to `client.blade.php`

- [ ] **Step 1: Create `resources/views/pages/seo-landing.blade.php`**

```blade
@extends('layouts.client')

@section('content')

<div class="has-fixed-nav">

    {{-- ─── Hero / intro ─────────────────────────────────────────────── --}}
    <section class="client-section seo-hero-section">
        <div class="client-container">
            <span class="section-eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="section-title">{{ $page['h1'] }}</h1>
            <p class="seo-location-line">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block;vertical-align:-1px;margin-right:4px"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Stockel Medical Center · Woluwe-Saint-Pierre · Brussels
            </p>
            <p class="section-body seo-intro">{{ $page['intro'] }}</p>
        </div>
    </section>

    {{-- ─── Main explanation ───────────────────────────────────────────── --}}
    <section class="client-section client-section--alt">
        <div class="client-container">
            <h2 class="seo-section-heading">{{ $page['main_heading'] }}</h2>
            <div class="seo-body-text">
                @foreach(explode("\n\n", $page['main_body']) as $paragraph)
                    <p>{{ trim($paragraph) }}</p>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── Consultation section ───────────────────────────────────────── --}}
    <section class="client-section">
        <div class="client-container seo-two-col">

            <div class="seo-col">
                <h2 class="seo-section-heading">{{ $page['consultation_heading'] }}</h2>
                <p class="section-body">{{ $page['consultation_body'] }}</p>
            </div>

            <div class="seo-col">
                <h2 class="seo-section-heading">{{ $page['suitability_heading'] }}</h2>
                <ul class="seo-check-list">
                    @foreach($page['suitability_points'] as $point)
                        <li>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </section>

    {{-- ─── Location block ─────────────────────────────────────────────── --}}
    <section class="client-section client-section--alt">
        <div class="client-container">
            <h2 class="seo-section-heading">Location</h2>
            <div class="seo-location-block">
                <p class="seo-location-name">{{ config('contact.location_name') }}</p>
                <p>{{ config('contact.address_line1') }}</p>
                <p>{{ config('contact.address_line2') }}</p>
                @if(config('contact.maps_link'))
                    <a href="{{ config('contact.maps_link') }}" target="_blank" rel="noopener noreferrer" class="seo-maps-link">View on Google Maps</a>
                @endif
            </div>
        </div>
    </section>

    {{-- ─── CTA block ──────────────────────────────────────────────────── --}}
    <section class="client-section seo-cta-section">
        <div class="client-container">
            <h2 class="seo-section-heading">Book a consultation</h2>
            <p class="section-body">To discuss whether this treatment may be suitable for you, book a consultation with Dr Sue-Liza Eta. You can book directly via Doctoranytime, or send a message through the contact form.</p>
            <div class="seo-cta-buttons">
                <a href="{{ config('contact.doctoranytime_url') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn-primary">
                    Book a consultation
                </a>
                <a href="/#contact-form" class="btn-secondary">
                    Contact the practice
                </a>
            </div>
        </div>
    </section>

    {{-- ─── Related pages ──────────────────────────────────────────────── --}}
    @if(!empty($page['related_pages']))
    <section class="client-section">
        <div class="client-container">
            <h2 class="seo-section-heading">Related services</h2>
            <ul class="seo-related-list">
                @foreach($page['related_pages'] as $related)
                    <li>
                        <a href="{{ $related['url'] }}"
                           @if(!empty($related['external'])) target="_blank" rel="noopener noreferrer" @endif>
                            {{ $related['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    @endif

    {{-- ─── Medical disclaimer ─────────────────────────────────────────── --}}
    <section class="client-section client-section--alt">
        <div class="client-container">
            <p class="seo-disclaimer">
                <strong>Important:</strong>
                This page is for general information only and does not replace a medical consultation.
                A personal consultation is needed to assess suitability, treatment options and possible risks.
            </p>
        </div>
    </section>

</div>

@push('head')
<style>
.seo-hero-section { padding-top: 5rem; }
.seo-location-line { color: var(--color-text-light); font-size: 0.875rem; margin-bottom: 1.5rem; }
.seo-intro { max-width: 42rem; }

.seo-section-heading {
    font-family: var(--font-heading);
    font-size: clamp(1.25rem, 2vw, 1.5rem);
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 1rem;
}

.seo-body-text p {
    color: var(--color-text-light);
    line-height: 1.75;
    margin-bottom: 1rem;
    max-width: 42rem;
}

.seo-two-col {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2.5rem;
}
@media (min-width: 768px) {
    .seo-two-col { grid-template-columns: 1fr 1fr; }
}

.seo-check-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.seo-check-list li {
    color: var(--color-text-light);
    line-height: 1.6;
    padding-left: 1.5rem;
    position: relative;
}
.seo-check-list li::before {
    content: '—';
    position: absolute;
    left: 0;
    color: var(--color-accent-dark);
}

.seo-location-block p {
    color: var(--color-text-light);
    line-height: 1.6;
    margin-bottom: 0.25rem;
}
.seo-location-name { font-weight: 600; color: var(--color-text) !important; }
.seo-maps-link {
    display: inline-block;
    margin-top: 0.75rem;
    color: var(--color-accent-dark);
    text-decoration: underline;
    text-underline-offset: 2px;
    font-size: 0.875rem;
}

.seo-cta-section { background: var(--color-bg-alt); }
.seo-cta-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1.5rem;
}

.seo-related-list {
    list-style: none;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem 2rem;
}
.seo-related-list li a {
    color: var(--color-accent-dark);
    text-decoration: underline;
    text-underline-offset: 2px;
    font-size: 0.9375rem;
}

.seo-disclaimer {
    font-size: 0.875rem;
    color: var(--color-text-light);
    line-height: 1.65;
    max-width: 44rem;
    border-left: 3px solid var(--color-border);
    padding-left: 1rem;
}
.seo-disclaimer strong { color: var(--color-text); }
</style>
@endpush

@endsection
```

- [ ] **Step 2: Verify template has no Blade syntax errors**

```bash
php artisan view:clear
```

Expected: Compiled views cleared with no error output.

---

### Task 5: Create sitemap route + XML view

**Files:**
- Create: `resources/views/sitemap.blade.php`
- Modify: `routes/web.php` (add sitemap route — do this in Task 7 together with all routes)

**Why:** Laravel serves the sitemap as a route so it can use `config('app.url')` dynamically rather than a hardcoded file.

- [ ] **Step 1: Create `resources/views/sitemap.blade.php`**

```blade
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ rtrim(config('app.url'), '/') }}/</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>

    @foreach(config('seo-pages', []) as $slug => $page)
    <url>
        <loc>{{ rtrim(config('app.url'), '/') }}/{{ $slug }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    <url>
        <loc>{{ rtrim(config('app.url'), '/') }}/privacy-policy</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

    <url>
        <loc>{{ rtrim(config('app.url'), '/') }}/legal-notice</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.3</priority>
    </url>

</urlset>
```

---

### Task 6: Update `public/robots.txt`

**Files:**
- Modify: `public/robots.txt`

- [ ] **Step 1: Replace the contents of `public/robots.txt`**

```txt
User-agent: *
Allow: /

Sitemap: https://drsuelizaeta.be/sitemap.xml
```

---

### Task 7: Add all routes in `routes/web.php`

**Files:**
- Modify: `routes/web.php`

- [ ] **Step 1: Add the following routes to `routes/web.php`**

Append after the existing `Route::post('/contact', ...)` line:

```php
use App\Http\Controllers\SeoPageController;

// Sitemap
Route::get('/sitemap.xml', function () {
    return response(view('sitemap')->render(), 200)
        ->header('Content-Type', 'text/xml');
})->name('sitemap');

// SEO landing pages
$seoSlugs = array_keys(config('seo-pages', []));
foreach ($seoSlugs as $slug) {
    Route::get('/' . $slug, [SeoPageController::class, 'show'])
        ->defaults('slug', $slug)
        ->name('seo.' . str_replace('-', '.', $slug));
}
```

**Note on the route loop:** Laravel resolves `config('seo-pages')` at route-loading time. This is fine because config is cached. If `php artisan route:cache` is used in production, run it after deployment.

- [ ] **Step 2: Verify all routes registered**

```bash
php artisan route:list
```

Expected output includes:
- `GET /sitemap.xml`
- `GET /botox-woluwe-saint-pierre`
- `GET /botox-stockel`
- `GET /aesthetic-medicine-woluwe-saint-pierre`
- `GET /hyaluronic-acid-fillers-woluwe-saint-pierre`
- `GET /medical-weight-loss-woluwe-saint-pierre`
- `GET /vascular-surgeon-woluwe-saint-pierre`
- `GET /varicose-veins-woluwe-saint-pierre`
- `GET /sclerotherapy-woluwe-saint-pierre`

Plus all existing routes (`/`, `/privacy-policy`, `/legal-notice`, `POST /contact`).

---

### Task 8: Update footer with "Treatments & Locations" SEO links

**Files:**
- Modify: `resources/views/partials/footer.blade.php`

**Why:** Adds subtle internal SEO links to the footer under a new "Treatments & Locations" column, without overloading the footer. Only the 5 most important SEO pages are linked.

- [ ] **Step 1: Add a new column to the footer grid**

In `resources/views/partials/footer.blade.php`, after the closing `</div>` of the "Contact & Location" column (before the closing `</div>` of `footer-grid`), add:

```blade
            <div>
                <p class="footer-label">Treatments &amp; Locations</p>
                <ul class="footer-nav-list" role="list">
                    <li><a href="/botox-woluwe-saint-pierre">Botox in Woluwe-Saint-Pierre</a></li>
                    <li><a href="/aesthetic-medicine-woluwe-saint-pierre">Aesthetic Medicine in Woluwe-Saint-Pierre</a></li>
                    <li><a href="/medical-weight-loss-woluwe-saint-pierre">Medical Weight Loss in Woluwe-Saint-Pierre</a></li>
                    <li><a href="/vascular-surgeon-woluwe-saint-pierre">Vascular Surgeon in Woluwe-Saint-Pierre</a></li>
                    <li><a href="/sclerotherapy-woluwe-saint-pierre">Sclerotherapy in Woluwe-Saint-Pierre</a></li>
                </ul>
            </div>
```

- [ ] **Step 2: Verify footer grid still looks correct**

Open the homepage in a browser (or run `npm run build` first if in development).

---

### Task 9: Build + verify

**Files:** None created — verification only.

- [ ] **Step 1: Clear caches and rebuild assets**

```bash
php artisan config:clear
php artisan view:clear
php artisan route:list
npm run build
```

Expected: No errors. Route list shows all expected routes.

- [ ] **Step 2: Start dev server**

```bash
php artisan serve
```

- [ ] **Step 3: Manual verification checklist**

Open in browser and confirm:

| URL | Expected result |
|-----|----------------|
| `http://localhost:8000/` | Homepage loads, no broken layout |
| `http://localhost:8000/sitemap.xml` | Valid XML, 11 `<url>` entries |
| `http://localhost:8000/robots.txt` | Shows 3-line content with Sitemap directive |
| `http://localhost:8000/botox-woluwe-saint-pierre` | SEO page loads with correct H1 |
| `http://localhost:8000/botox-stockel` | SEO page loads |
| `http://localhost:8000/aesthetic-medicine-woluwe-saint-pierre` | SEO page loads |
| `http://localhost:8000/hyaluronic-acid-fillers-woluwe-saint-pierre` | SEO page loads |
| `http://localhost:8000/medical-weight-loss-woluwe-saint-pierre` | SEO page loads |
| `http://localhost:8000/vascular-surgeon-woluwe-saint-pierre` | SEO page loads |
| `http://localhost:8000/varicose-veins-woluwe-saint-pierre` | SEO page loads |
| `http://localhost:8000/sclerotherapy-woluwe-saint-pierre` | SEO page loads |
| `http://localhost:8000/privacy-policy` | Privacy policy loads unchanged |
| `http://localhost:8000/legal-notice` | Legal notice loads unchanged |
| Footer on homepage | "Treatments & Locations" column visible |

- [ ] **Step 4: Spot-check page-level meta**

View source of `/botox-woluwe-saint-pierre` and confirm:
- `<title>` reads: `Botox Woluwe-Saint-Pierre | Dr Sue-Liza Eta – Aesthetic Medicine`
- `<meta name="description"` is unique to that page
- `<link rel="canonical"` points to `https://drsuelizaeta.be/botox-woluwe-saint-pierre`
- `<meta property="og:title"` is set correctly

View source of `/` and confirm `<title>` still reads the default from `config('seo.title')`.
