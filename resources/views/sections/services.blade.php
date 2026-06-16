<section id="services" class="services-section services-section-dark">
    <div class="client-container">
        <div class="services-grid-dark reveal-stagger">
            @foreach(config('client-services.items', []) as $service)
                <article class="service-panel">
                    @if(!empty($service['icon']))
                        <img src="{{ asset($service['icon']) }}" alt="{{ $service['name'] }} icon" class="service-panel-icon" loading="lazy">
                    @endif
                    <h3>{{ $service['name'] }}</h3>
                    <p>{{ $service['description'] }}</p>
                    <a href="#contact" class="service-panel-link">
                        Learn more<span class="sr-only"> about {{ $service['name'] }}</span>
                    </a>
                </article>
            @endforeach
        </div>

    </div>
</section>
