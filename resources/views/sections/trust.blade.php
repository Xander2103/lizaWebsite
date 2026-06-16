@if(!empty(config('site.trust_points')))
<section id="trust" class="client-section">
    <div class="client-container">

        <div class="section-header reveal">
            <span class="section-eyebrow">Our commitment</span>
            <h2 class="section-title">{{ config('site.trust_section_title') }}</h2>
        </div>

        <ul class="trust-list reveal-stagger" role="list">
            @foreach(config('site.trust_points') as $point)
                <li class="trust-list-item">
                    <span class="trust-list-check" aria-hidden="true"></span>
                    <p>{{ $point }}</p>
                </li>
            @endforeach
        </ul>

    </div>
</section>
@endif
