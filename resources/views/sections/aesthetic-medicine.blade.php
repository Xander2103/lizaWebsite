<section id="aesthetic-medicine" class="client-section" aria-labelledby="aesthetic-medicine-heading">

    <div class="client-container">
        <div class="section-header aesthetic-section-header reveal">
            <span class="section-eyebrow">{{ config('service-details.aesthetic_medicine.eyebrow') }}</span>
            <h2 class="section-title service-detail-heading" id="aesthetic-medicine-heading">
                {!! nl2br(e(config('service-details.aesthetic_medicine.heading'))) !!}
            </h2>
            <p class="section-intro">{{ config('service-details.aesthetic_medicine.intro') }}</p>
        </div>
    </div>

    @if(!empty(config('service-details.aesthetic_medicine.image')))
        <div class="aesthetic-banner-wrap reveal">
            <div class="aesthetic-banner">
                <img src="{{ asset(config('service-details.aesthetic_medicine.image')) }}" alt="{{ config('service-details.aesthetic_medicine.image_alt') }}" class="aesthetic-banner-image" loading="lazy">
                @if(!empty(config('service-details.aesthetic_medicine.overlay_text')))
                    <div class="aesthetic-banner-overlay">
                        <p>{!! nl2br(e(config('service-details.aesthetic_medicine.overlay_text'))) !!}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="client-container">
        @if(!empty(config('service-details.aesthetic_medicine.features')))
            <div class="aesthetic-feature-grid reveal-stagger">
                @foreach(config('service-details.aesthetic_medicine.features') as $feature)
                    <div class="aesthetic-feature-card">
                        <h3>{{ $feature['title'] }}</h3>
                        <p>{{ $feature['description'] }}</p>
                    </div>
                @endforeach

                @if(!empty(config('service-details.aesthetic_medicine.cta_card')))
                    <div class="aesthetic-cta-card">
                        <h3>{{ config('service-details.aesthetic_medicine.cta_card.title') }}</h3>
                        <p>{{ config('service-details.aesthetic_medicine.cta_card.text') }}</p>
                        @if(!empty(config('service-details.aesthetic_medicine.cta_card.button')))
                            <a href="#contact" class="btn btn-primary">{{ config('service-details.aesthetic_medicine.cta_card.button') }}</a>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>

</section>
