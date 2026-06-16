<section id="weight-loss" class="client-section-alt" aria-labelledby="weight-loss-heading">
    <div class="client-container">
        <div class="weight-loss-grid">

            <div class="weight-loss-text-header reveal">
                <span class="section-eyebrow">{{ config('service-details.weight_loss.eyebrow') }}</span>
                <h2 class="section-title service-detail-heading" id="weight-loss-heading">
                    {!! nl2br(e(config('service-details.weight_loss.heading'))) !!}
                </h2>
                <p class="about-text">{{ config('service-details.weight_loss.intro') }}</p>
            </div>

            <div class="weight-loss-image-wrap reveal">
                @if(!empty(config('service-details.weight_loss.image')))
                    <div class="about-image-card">
                        <img src="{{ asset(config('service-details.weight_loss.image')) }}" alt="{{ config('service-details.weight_loss.image_alt') }}" class="about-image" loading="lazy">
                    </div>
                @else
                    <div class="about-image-card">
                        <div class="image-fallback">
                            <span>Photo coming soon</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="weight-loss-features-wrap reveal">
                @if(!empty(config('service-details.weight_loss.features')))
                    <ul class="service-detail-features">
                        @foreach(config('service-details.weight_loss.features') as $feature)
                            <li class="service-detail-feature">
                                <h3>{{ $feature['title'] }}</h3>
                                <p>{{ $feature['description'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if(!empty(config('service-details.weight_loss.cta_label')))
                    <div class="weight-loss-cta-row">
                        @if(!empty(config('service-details.weight_loss.cta_note')))
                            <p class="weight-loss-cta-note">{{ config('service-details.weight_loss.cta_note') }}</p>
                        @endif
                        <a href="{{ config('site.appointment_url') }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">{{ config('service-details.weight_loss.cta_label') }}</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
