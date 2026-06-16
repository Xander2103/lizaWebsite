<?php

$appointmentUrl = 'https://www.doctoranytime.be/en/Account/Login?loginType=1&returnUrl=%2Fen%2FdoctorcrmV2%2FProfile%2FRedesign%3FdoctorAdminId%3D0%26doctorid%3D109025&action=login&controller=account';

return [
    // Appointment booking — single source for every booking CTA on the site
    'appointment_url' => $appointmentUrl,

    // Basic info
    'name'          => 'Dr Sue-Liza Eta',
    'short_name'    => 'Dr Sue-Liza',
    'tagline'       => 'Specialist care with a personal, refined approach',
    'intro_short'   => 'Dr Sue-Liza Eta offers expert medical care across vascular surgery, medically guided weight loss and aesthetic medicine, with a focus on safety, clarity and individual attention.',
    'intro_long'    => 'With extensive experience in specialist medical care, Dr Sue-Liza Eta brings a patient-centred, evidence-informed approach to every consultation. Combining medical expertise with genuine care, she focuses on understanding your unique needs and providing personalised guidance in a calm, confidential setting.',
    'business_type' => 'medical specialist',

    // Hero
    'hero_heading'    => 'Dr Sue-Liza Eta',
    'hero_subheading' => 'Personalized medical care in Brussels, focused on vascular health, sustainable weight loss, and natural aesthetic results.',
    'hero_location'   => 'Brussels • Belgium',
    'nav_subtitle'    => 'MEDICAL DOCTOR · VASCULAR SURGEON',

    // About
    'about_title'      => "A Doctor Who Listens,\nThen Acts.",
    'about_body'       => 'Dr Sue-Liza Eta is a medical doctor and vascular surgeon practicing in Brussels. Her career spans vascular medicine, metabolic health, and aesthetic medicine — three disciplines united by a single conviction: that medicine should serve the whole person, not just a symptom.',
    'about_paragraph_2' => 'Her approach is evidence-based, human, precise, and deeply personalised. Each consultation begins with genuine attention — understanding your history, your goals, and what matters most to you.',
    'about_values' => [
        [
            'title'       => 'Evidence-Based',
            'description' => 'Every treatment decision grounded in current medical science.',
        ],
        [
            'title'       => 'Human & Precise',
            'description' => 'Attentive listening combined with surgical precision.',
        ],
        [
            'title'       => 'Personalised',
            'description' => 'No two patients are the same — neither are their care plans.',
        ],
    ],
    'about_quote' => 'The goal is not to change you, but to help you feel better, healthier, and more confident.',

    // Navigation — order matches section flow: Home, Services, About, Approach, Contact
    'nav_items' => [
        ['label' => 'About',      'href' => '/'],
        ['label' => 'Vascular Surgery',  'href' => '#vascular-surgery'],
        ['label' => 'Weight Loss',     'href' => '#weight-loss'],
        ['label' => 'Aesthetic Medicine',  'href' => '#aesthetic-medicine'],
        ['label' => 'Contact',   'href' => '#contact'],
    ],

    // CTAs
    'cta_primary'   => 'Book an appointment',
    'cta_secondary' => 'Learn More',

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
            'title'       => 'Initial consultation',
            'description' => 'We start by listening. Understanding your goals, concerns and medical history in a relaxed, confidential setting.',
        ],
        [
            'title'       => 'Personal assessment',
            'description' => 'A thorough, professional evaluation to determine the best approach for your individual needs and safety profile.',
        ],
        [
            'title'       => 'Treatment plan',
            'description' => 'A clear, personalised plan outlining options, timelines and expected outcomes — with no pressure or surprise costs.',
        ],
        [
            'title'       => 'Follow-up and guidance',
            'description' => 'Ongoing support and monitoring to ensure your comfort, safety and satisfaction throughout your journey.',
        ],
    ],

    // CTA banner
    'cta_banner_heading'        => 'Book your consultation',
    'cta_banner_heading_accent' => 'with Dr Sue-Liza Eta today.',
    'cta_banner_subheading'     => 'Stockel Medical Center · Brussels · Available via Doctoranytime',
    'cta_banner_button_label'   => 'Book an Appointment',

    // Trust / values section
    'trust_section_title' => 'Why patients choose Dr Sue-Liza',
    'trust_points' => [
        'Medical expertise — board-certified specialist with extensive experience',
        'Personalised care — every consultation, every plan tailored to you',
        'Clear communication — transparent, no jargon, no pressure',
        'Safety first — your wellbeing is the only priority',
    ],

    // Section toggles
    'sections' => [
        'hero'               => true,
        'services'           => true,
        'about'              => true,
        'vascular_surgery'   => true,
        'weight_loss'        => true,
        'aesthetic_medicine' => true,
        'approach'           => false,
        'trust'              => false,
        'cta_banner'         => true,
        'contact'            => true,
        'gallery'            => false,
        'location'           => false,
    ],

    // Footer
    'footer_text' => '© 2026 Dr Sue-Liza Eta. All rights reserved.',
    'footer_nav_items' => [
        ['label' => 'About Dr Eta',         'href' => '/'],
        ['label' => 'Vascular Surgery',     'href' => '#vascular-surgery'],
        ['label' => 'Medical Weight Loss',  'href' => '#weight-loss'],
        ['label' => 'Aesthetic Medicine',   'href' => '#aesthetic-medicine'],
        ['label' => 'Book an Appointment',  'href' => $appointmentUrl],
    ],
    'whatsapp_url'   => null,
    'maps_link'      => null,
    'maps_embed_url' => null,
];
