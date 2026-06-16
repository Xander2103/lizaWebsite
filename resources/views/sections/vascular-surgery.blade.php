<section id="vascular-surgery" class="client-section" aria-labelledby="vascular-surgery-heading">
    <div class="client-container">
        <div class="two-column-grid vascular-grid">

            <div class="reveal">
                <span class="section-eyebrow">{{ config('service-details.vascular_surgery.eyebrow') }}</span>
                <h2 class="section-title service-detail-heading" id="vascular-surgery-heading">
                    {!! nl2br(e(config('service-details.vascular_surgery.heading'))) !!}
                </h2>
                <p class="about-text">{{ config('service-details.vascular_surgery.intro') }}</p>

                @if(!empty(config('service-details.vascular_surgery.features')))
                    <ul class="vascular-feature-grid">
                        @foreach(config('service-details.vascular_surgery.features') as $feature)
                            <li class="vascular-feature-card">
                                <h3>{{ $feature['title'] }}</h3>
                                <p>{{ $feature['description'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if(!empty(config('service-details.vascular_surgery.cta_label')))
                    <div class="vascular-cta-row">
                        <a href="#contact" class="btn btn-primary">{{ config('service-details.vascular_surgery.cta_label') }}</a>
                    </div>
                @endif
            </div>

            <div class="reveal">
                @if(!empty(config('service-details.vascular_surgery.image')))
                    <div class="vascular-image-card">
                        <img src="{{ asset(config('service-details.vascular_surgery.image')) }}" alt="{{ config('service-details.vascular_surgery.image_alt') }}" class="vascular-image" loading="lazy">
                    </div>
                @else
                    <div class="about-image-card">
                        <div class="image-fallback">
                            <span>Photo coming soon</span>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
