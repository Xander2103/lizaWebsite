<section id="about" class="client-section-alt" aria-labelledby="about-heading">
    <div class="client-container">
        <div class="about-grid">

            <div class="about-text-header reveal">
                <span class="section-eyebrow">About</span>
                <span class="hero-centered-divider" aria-hidden="true"></span>
                <h2 class="section-title about-heading" id="about-heading">
                    {!! nl2br(e(config('site.about_title', config('site.name')))) !!}
                </h2>
                <p class="about-text">{{ config('site.about_body', config('site.intro_long')) }}</p>
            </div>

            <div class="about-image-wrap reveal">
                @if(!empty(config('images.about')))
                    <div class="about-image-card">
                        <img src="{{ asset(config('images.about')) }}" alt="{{ config('images.about_alt') }}" class="about-image" loading="lazy">
                    </div>
                @elseif(!empty(config('images.placeholder_about')))
                    <div class="about-image-card">
                        <img src="{{ asset(config('images.placeholder_about')) }}" alt="{{ config('images.about_alt') }}" class="about-image" loading="lazy">
                    </div>
                @else
                    <div class="about-image-card">
                        <div class="image-fallback">
                            <span>Photo coming soon</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="about-content-wrap reveal">
                @if(!empty(config('site.about_paragraph_2')))
                    <p class="about-text">{{ config('site.about_paragraph_2') }}</p>
                @endif

                @if(!empty(config('site.about_values')))
                    <ul class="about-values">
                        @foreach(config('site.about_values') as $value)
                            <li class="about-value-row">
                                <span class="about-value-check" aria-hidden="true"></span>
                                <div class="about-value-text">
                                    <strong>{{ $value['title'] }}</strong>
                                    <p>{{ $value['description'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if(!empty(config('site.about_quote')))
                    <blockquote class="about-quote">
                        <p>{{ config('site.about_quote') }}</p>
                    </blockquote>
                @endif

                @if(!empty(config('site.cta_primary')))
                    <a href="{{ config('site.appointment_url') }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">{{ config('site.cta_primary') }}</a>
                @endif
            </div>

        </div>
    </div>
</section>
