<section id="approach" class="client-section-alt" aria-labelledby="approach-heading">
    <div class="client-container">

        <div class="section-header reveal">
            <span class="section-eyebrow">How we work</span>
            <h2 class="section-title" id="approach-heading">{{ config('site.approach_title') }}</h2>
        </div>

        <ol class="approach-steps reveal-stagger" aria-label="Consultation steps">
            @foreach(config('site.approach_steps', []) as $i => $step)
                <li class="approach-step">
                    <span class="approach-step-number" aria-hidden="true">{{ $i + 1 }}</span>
                    <div class="approach-step-body">
                        <h3>{{ $step['title'] }}</h3>
                        <p>{{ $step['description'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>

    </div>
</section>
