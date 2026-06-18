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
