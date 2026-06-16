<section id="location" class="client-section-alt">
    <div class="client-container">

        <div class="section-header">
            <span class="section-eyebrow">Locatie</span>
            <h2 class="section-title">Hoe ons vinden</h2>
        </div>

        <div class="two-column-grid">

            <div class="info-card">
                <p style="font-weight:600;color:var(--color-primary);font-size:1rem;margin:0 0 .5rem;">
                    {{ config('site.name') }}
                </p>
                <p style="color:var(--color-text-light);margin-bottom:1rem;">
                    {{ config('site.address') }}<br>
                    {{ config('site.city') }}, {{ config('site.region') }}
                </p>
                @if(!empty(config('site.phone')))
                    <p style="margin-bottom:.5rem;">
                        <a href="tel:{{ config('site.phone') }}"
                           style="color:var(--color-primary);font-weight:600;text-decoration:none;">
                            {{ config('site.phone') }}
                        </a>
                    </p>
                @endif
                @if(!empty(config('site.opening_hours')))
                    <ul class="opening-hours-list" role="list" style="margin-top:1.5rem;">
                        @foreach(config('site.opening_hours') as $day => $hours)
                            <li>
                                <span class="hours-day">{{ $day }}</span>
                                <span class="hours-time">{{ $hours }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if(!empty(config('site.maps_link')))
                    <a href="{{ config('site.maps_link') }}" target="_blank" rel="noopener noreferrer"
                       class="btn btn-secondary" style="margin-top:1.5rem;">
                        Bekijk op Google Maps
                    </a>
                @endif
            </div>

            <div>
                @if(!empty(config('site.maps_embed_url')))
                    <div style="border-radius:.75rem;overflow:hidden;height:360px;">
                        <iframe
                            src="{{ config('site.maps_embed_url') }}"
                            width="100%" height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Locatie {{ config('site.name') }} op Google Maps"
                        ></iframe>
                    </div>
                @else
                    <div class="image-fallback" style="min-height:360px;">
                        <span>Google Maps wordt hier gekoppeld.</span>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
