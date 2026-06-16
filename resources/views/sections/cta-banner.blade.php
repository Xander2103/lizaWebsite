<section class="cta-banner" aria-label="Call to action">
    <div class="client-container cta-banner-inner">

        <div class="reveal">
            <h2 class="cta-banner-heading">
                {{ config('site.cta_banner_heading') }}
                @if(!empty(config('site.cta_banner_heading_accent')))
                    <span class="cta-banner-heading-accent">{{ config('site.cta_banner_heading_accent') }}</span>
                @endif
            </h2>

            @if(!empty(config('site.cta_banner_subheading')))
                <p class="cta-banner-subheading">{{ config('site.cta_banner_subheading') }}</p>
            @endif
        </div>

        <div class="cta-banner-actions reveal">
            @if(!empty(config('site.cta_banner_button_label')))
                <a href="#contact" class="btn btn-primary">
                    {{ config('site.cta_banner_button_label') }}<span aria-hidden="true"> →</span>
                </a>
            @endif
        </div>

    </div>
</section>
