<section
    id="hero"
    class="hero-centered"
    @if(!empty(config('images.hero')))
        style="--hero-image: url('{{ asset(config('images.hero')) }}')"
    @endif
    aria-label="Welcome — {{ config('site.name') }}"
>
    <div class="hero-centered-content">

        @if(!empty(config('site.hero_location')))
            <div class="hero-eyebrow-row">
                <span class="hero-eyebrow-line" aria-hidden="true"></span>
                <span class="hero-centered-eyebrow">{{ config('site.hero_location') }}</span>
                <span class="hero-eyebrow-line" aria-hidden="true"></span>
            </div>
        @endif

        @if(!empty(config('site.hero_heading')))
            <h1>{{ config('site.hero_heading') }}</h1>
        @else
            <h1>{{ config('site.tagline') }}</h1>
        @endif

        @php($heroServiceNames = collect(config('client-services.items', []))->pluck('name')->filter())
        @if($heroServiceNames->isNotEmpty())
            <p class="hero-centered-services">
                @foreach($heroServiceNames as $name)
                    <span>{{ $name }}</span>
                @endforeach
            </p>
        @endif

        <span class="hero-centered-divider" aria-hidden="true"></span>

        <p>{{ config('site.hero_subheading', config('site.intro_short')) }}</p>

        <div class="cta-row">
            @if(!empty(config('site.cta_primary')))
                <a href="#contact" class="btn btn-primary">{{ config('site.cta_primary') }}</a>
            @endif
            @if(!empty(config('site.cta_secondary')))
                <a href="#approach" class="btn btn-secondary-light">{{ config('site.cta_secondary') }}</a>
            @endif
        </div>

        @if(!empty(config('site.trust_indicators')))
            <ul class="hero-centered-trust" aria-label="Key trust points">
                @foreach(config('site.trust_indicators') as $indicator)
                    <li>{{ $indicator }}</li>
                @endforeach
            </ul>
        @endif

    </div>

    <a href="#services" class="hero-scroll-cue" aria-label="Scroll to explore">
        <span class="hero-scroll-cue-arrow" aria-hidden="true"></span>
    </a>

</section>
