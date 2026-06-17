@extends('layouts.client')

@section('content')
<div class="has-fixed-nav">
    <section class="client-section">
        <div class="client-container">
            <div class="privacy-policy-wrap">

                <span class="section-eyebrow">Legal</span>
                <h1 class="section-title">Privacy Policy</h1>

                <div class="form-alert form-alert-error" style="margin-bottom:2rem;">
                    <strong>Note for the client:</strong> This privacy policy is practical website copy. It has not been reviewed by a legal professional. Please have it verified by a qualified legal advisor before putting this site into production use.
                </div>

                <p style="color:var(--color-text-light); font-size:0.875rem; margin-bottom:2rem;">Last updated: {{ date('F Y') }}</p>

                <h2>1. Who is responsible for this website</h2>
                <p>
                    Dr Sue-Liza Eta<br>
                    Stockel Medical Center<br>
                    Avenue de Hinnisdael 3<br>
                    1150 Brussels, Belgium<br>
                    <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a>
                </p>

                <h2>2. What personal data is collected</h2>
                <p>When you use the contact form on this website, the following information may be collected:</p>
                <ul>
                    <li>Full name</li>
                    <li>Email address</li>
                    <li>Phone number (optional)</li>
                    <li>Selected service or topic</li>
                    <li>Message content</li>
                    <li>Technical data: your IP address may be used temporarily for spam prevention and rate limiting. It is not stored beyond the current request.</li>
                </ul>

                <h2>3. Important: this form is not for urgent medical matters</h2>
                <p>
                    <strong>The contact form is not intended for urgent medical issues.</strong>
                    Please do not send sensitive or detailed medical information through this form.
                    For urgent health concerns, contact a medical professional directly or call emergency services.
                    If you wish to discuss your medical situation, please book a consultation via
                    <a href="{{ config('contact.doctoranytime_url') }}" target="_blank" rel="noopener noreferrer">Doctoranytime</a>
                    or contact the practice directly.
                </p>

                <h2>4. Why your data is processed and the legal basis</h2>
                <p>Depending on the context, your enquiry data may be processed on one or more of the following bases:</p>
                <ul>
                    <li><strong>Consent</strong> — you have actively agreed via the checkbox on the contact form that your information may be used to respond to your enquiry.</li>
                    <li><strong>Legitimate interest</strong> — responding to your enquiry, preventing spam and abuse, and maintaining basic website security.</li>
                    <li><strong>Steps prior to a potential appointment</strong> — where your enquiry is a request for information ahead of a medical or aesthetic consultation, processing may be necessary to take steps at your request.</li>
                </ul>

                <h2>5. How long your data is kept</h2>
                <p>
                    Contact enquiries are not kept longer than necessary.
                    As a practical guideline, enquiry records are retained for up to 12 months.
                    If an ongoing care relationship or legal obligation requires longer retention, data may be kept for the duration of that obligation.
                </p>

                <h2>6. Who your data is shared with</h2>
                <p>Your data is not sold or shared with third parties for marketing purposes. It may be processed by:</p>
                <ul>
                    <li>The website hosting provider, as part of normal server operation</li>
                    <li>Email service providers used to deliver your enquiry to the practice</li>
                </ul>
                <p>No other third parties receive contact form data.</p>

                <h2>7. Third-party services on this website</h2>
                <p>This website includes links or embedded content from third-party services. When you interact with them, those services may process your data under their own privacy policies:</p>
                <ul>
                    <li><strong>Doctoranytime</strong> — clicking the booking link takes you to doctoranytime.be, which operates under its own privacy policy.</li>
                    <li><strong>Google Maps</strong> — the location map is only loaded if you click "Load map". Loading it causes your browser to connect to Google servers. Google may process data including your IP address. See <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Google's privacy policy</a>.</li>
                    <li><strong>Instagram</strong> — clicking the Instagram link takes you to instagram.com, operated by Meta. Subject to <a href="https://privacycenter.instagram.com/policy" target="_blank" rel="noopener noreferrer">Meta's privacy policy</a>.</li>
                    <li><strong>Google Fonts</strong> — this website loads fonts from Google Fonts, which involves a connection to Google servers when the page loads.</li>
                </ul>

                <h2>8. Cookies</h2>
                <p>This website uses only technically necessary cookies:</p>
                <ul>
                    <li>A session cookie to maintain your form state and CSRF security token (required for form security)</li>
                </ul>
                <p>No analytics, advertising, or tracking cookies are used. If you load the Google Maps embed, Google may set its own cookies.</p>

                <h2>9. Your rights under GDPR</h2>
                <p>Under the General Data Protection Regulation (GDPR), you have the following rights regarding your personal data:</p>
                <ul>
                    <li>Right of <strong>access</strong> — to know what data is held about you</li>
                    <li>Right to <strong>rectification</strong> — to correct inaccurate data</li>
                    <li>Right to <strong>erasure</strong> — to request deletion of your data</li>
                    <li>Right to <strong>restriction</strong> of processing</li>
                    <li>Right to <strong>object</strong> to processing based on legitimate interest</li>
                    <li>Right to <strong>data portability</strong> (where applicable)</li>
                </ul>
                <p>To exercise any of these rights, please contact: <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a></p>
                <p>
                    You also have the right to lodge a complaint with the
                    <strong>Belgian Data Protection Authority (Gegevensbeschermingsautoriteit)</strong>:<br>
                    <a href="https://www.dataprotectionauthority.be" target="_blank" rel="noopener noreferrer">www.dataprotectionauthority.be</a>
                </p>

                <h2>10. Questions about this policy</h2>
                <p>For any questions about this privacy policy or the handling of your data, please contact:
                    <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a>
                </p>

            </div>
        </div>
    </section>
</div>

@push('head')
<style>
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
