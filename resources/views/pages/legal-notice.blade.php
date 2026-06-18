@extends('layouts.client')

@section('content')
<div class="has-fixed-nav">
    <section class="client-section">
        <div class="client-container">
            <div class="privacy-policy-wrap">

                <span class="section-eyebrow">Legal</span>
                <h1 class="section-title">Legal Notice</h1>

                <p class="privacy-updated">Last updated: {{ date('F Y') }}</p>

                <h2>Website owner and publisher</h2>
                <p>
                    <strong>Dr Sue-Liza Eta</strong><br>
                    Stockel Medical Center<br>
                    Avenue de Hinnisdael 3<br>
                    1150 Brussels, Belgium
                </p>
                <p>
                    Email: <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a><br>
                    Phone: <a href="tel:{{ config('contact.phone') }}">{{ config('contact.phone') }}</a><br>
                    Mobile: <a href="tel:{{ config('contact.phone_mobile') }}">{{ config('contact.phone_mobile') }}</a>
                </p>
                <p>VAT number: BE0793838003</p>

                <h2>Website development and maintenance</h2>
                <p>
                    This website was developed and is maintained by:<br>
                    <strong>VanMalderStudio</strong><br>
                    <a href="https://vanmalderstudio.be/en" target="_blank" rel="noopener noreferrer">vanmalderstudio.be</a>
                </p>

                <h2>Liability</h2>
                <p>
                    The information on this website is provided for general informational purposes only
                    and does not replace a medical consultation, diagnosis or treatment.
                </p>
                <p>
                    Dr Sue-Liza Eta makes reasonable efforts to keep the information on this website accurate
                    and up to date, but cannot guarantee that all information is complete, current or free from errors.
                </p>

                <h2>External links</h2>
                <p>
                    This website may contain links to external websites, such as Doctoranytime, Google Maps and Instagram.
                    Dr Sue-Liza Eta is not responsible for the content, availability or privacy practices of these external websites.
                </p>

                <h2>Intellectual property</h2>
                <p>
                    The content, text, design and visual elements on this website may not be copied, reproduced
                    or reused without prior permission, unless otherwise permitted by law.
                </p>

                <p style="margin-top:2rem;">
                    <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                </p>

            </div>
        </div>
    </section>
</div>

@push('head')
<style>
.privacy-updated {
    color: var(--color-text-light);
    font-size: 0.875rem;
    margin-bottom: 2rem;
}
.privacy-policy-wrap h2 {
    font-family: var(--font-heading);
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--color-text);
    margin-top: 2rem;
    margin-bottom: 0.5rem;
}
.privacy-policy-wrap p,
.privacy-policy-wrap li {
    color: var(--color-text-light);
    line-height: 1.7;
    margin-bottom: 0.5rem;
}
.privacy-policy-wrap ul {
    list-style: disc;
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}
.privacy-policy-wrap a {
    color: var(--color-accent-dark);
    text-decoration: underline;
    text-underline-offset: 2px;
}
.privacy-policy-wrap strong { color: var(--color-text); }
</style>
@endpush
@endsection
