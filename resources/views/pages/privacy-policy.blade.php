```blade
@extends('layouts.client')

@section('content')
<div class="has-fixed-nav">
    <section class="client-section">
        <div class="client-container">
            <div class="privacy-policy-wrap">

                <span class="section-eyebrow">Legal</span>
                <h1 class="section-title">Privacy Policy</h1>

                {{-- Developer note: this privacy policy is practical website copy, not a lawyer-reviewed document. Have it verified before going live. --}}

                <p class="privacy-updated">Last updated: {{ date('F Y') }}</p>

                <h2>1. Who is responsible for this website</h2>
                <p>
                    The data controller for this website is:
                </p>
                <p>
                    <strong>Dr Sue-Liza Eta</strong><br>
                    Stockel Medical Center<br>
                    Avenue de Hinnisdael 3<br>
                    1150 Brussels, Belgium<br>
                    <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a>
                </p>
                <p>
                    For questions about this privacy policy or the processing of your personal data,
                    you can contact Dr Sue-Liza Eta at the email address above.
                </p>

                <h2>2. What personal data is collected</h2>
                <p>When you use the contact form on this website, the following information may be collected:</p>
                <ul>
                    <li>Full name</li>
                    <li>Email address</li>
                    <li>Phone number, if provided</li>
                    <li>Selected service or topic</li>
                    <li>Message content</li>
                    <li>Technical data such as your IP address, which may be processed temporarily for spam prevention, rate limiting and website security</li>
                </ul>
                <p>
                    Please do not send sensitive or detailed medical information through the contact form.
                </p>

                <h2>3. Important: this form is not for urgent medical matters</h2>
                <p>
                    <strong>The contact form is not intended for urgent medical issues.</strong>
                    For urgent health concerns, please contact a medical professional directly or call emergency services.
                    If you wish to discuss your medical situation, please book a consultation via
                    <a href="{{ config('contact.doctoranytime_url') }}" target="_blank" rel="noopener noreferrer">Doctoranytime</a>
                    or contact the practice directly by phone.
                </p>

                <h2>4. Why your data is processed and the legal basis</h2>
                <p>Your personal data may be processed for the following purposes:</p>
                <ul>
                    <li>To respond to your enquiry</li>
                    <li>To handle appointment or consultation-related questions</li>
                    <li>To prevent spam, abuse and misuse of the contact form</li>
                    <li>To maintain the security and proper functioning of the website</li>
                </ul>

                <p>Depending on the context, the legal basis may be:</p>
                <ul>
                    <li><strong>Consent</strong> — when you actively agree via the checkbox on the contact form</li>
                    <li><strong>Legitimate interest</strong> — to respond to enquiries, prevent spam and maintain website security</li>
                    <li><strong>Steps prior to a potential appointment</strong> — when your enquiry relates to a possible consultation or appointment</li>
                </ul>

                <h2>5. How long your data is kept</h2>
                <p>
                    Contact form enquiries are not kept longer than necessary.
                    As a practical guideline, contact form enquiries may be retained for up to 12 months.
                    If an ongoing care relationship, administrative need or legal obligation requires a longer retention period,
                    the data may be kept for the duration required by that obligation.
                </p>

                <h2>6. Who your data may be shared with</h2>
                <p>
                    Your personal data is not sold or shared with third parties for marketing purposes.
                    Your data may be processed by the following service providers where necessary:
                </p>
                <ul>
                    <li>The website hosting provider, for normal website hosting and server operation</li>
                    <li>Brevo, the email service provider used to send contact form notifications and confirmation emails</li>
                    <li>VanMalderStudio, for technical website development, hosting support, maintenance and security where necessary</li>
                </ul>
                <p>
                    These parties may only process personal data where this is necessary for the operation,
                    maintenance, security or communication functions of the website.
                </p>

                <h2>7. Third-party services on this website</h2>
                <p>
                    This website may include links to or embedded content from third-party services.
                    When you interact with these services, they may process your data under their own privacy policies.
                </p>
                <ul>
                    <li>
                        <strong>Doctoranytime</strong> —
                        clicking the booking link takes you to doctoranytime.be.
                        Doctoranytime operates under its own privacy policy.
                    </li>
                    <li>
                        <strong>Google Maps</strong> —
                        this website embeds a Google Maps location map.
                        When the page loads, your browser may connect to Google servers.
                        Google may process data such as your IP address under its own privacy policy.
                        See
                        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Google's privacy policy</a>.
                    </li>
                    <li>
                        <strong>Instagram</strong> —
                        clicking the Instagram link takes you to instagram.com, operated by Meta.
                        Meta processes data under its own privacy policy.
                        See
                        <a href="https://privacycenter.instagram.com/policy" target="_blank" rel="noopener noreferrer">Meta's privacy policy</a>.
                    </li>
                    <li>
                        <strong>Google Fonts</strong> —
                        this website may load fonts from Google Fonts.
                        This can involve a connection to Google servers when the page loads.
                        If fonts are hosted locally in the future, this section may be updated.
                    </li>
                </ul>

                <h2>8. Cookies</h2>
                <p>This website only uses technically necessary cookies.</p>
                <ul>
                    <li>A session cookie needed for form security</li>
                    <li>A CSRF security token to protect the contact form against misuse</li>
                </ul>
                <p>
                    No analytics, advertising or tracking cookies are intentionally used by this website.
                    Please note that third-party services such as Google Maps may set their own cookies
                    or process technical data when loaded.
                </p>

                <h2>9. Your rights under GDPR</h2>
                <p>
                    Under the General Data Protection Regulation, you have rights regarding your personal data, including:
                </p>
                <ul>
                    <li>The right to access your personal data</li>
                    <li>The right to correct inaccurate personal data</li>
                    <li>The right to request deletion of your personal data</li>
                    <li>The right to restrict processing</li>
                    <li>The right to object to processing based on legitimate interest</li>
                    <li>The right to data portability, where applicable</li>
                    <li>The right to withdraw consent, where processing is based on consent</li>
                </ul>
                <p>
                    To exercise these rights, please contact:
                    <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a>
                </p>
                <p>
                    You also have the right to lodge a complaint with the
                    <strong>Belgian Data Protection Authority (Gegevensbeschermingsautoriteit)</strong>:<br>
                    <a href="https://www.dataprotectionauthority.be" target="_blank" rel="noopener noreferrer">www.dataprotectionauthority.be</a>
                </p>

                <h2>10. Questions about this policy</h2>
                <p>
                    For any questions about this privacy policy or the handling of your personal data, please contact:
                    <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a>
                </p>

                <hr class="privacy-divider">

                <h2>Legal Notice</h2>
                <p>
                    <strong>Dr Sue-Liza Eta</strong><br>
                    Stockel Medical Center<br>
                    Avenue de Hinnisdael 3<br>
                    1150 Brussels, Belgium<br>
                    Email: <a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a><br>
                    Phone: 02/705.30.32<br>
                    Mobile: 0471.48.01.48
                </p>

                <p>
                    VAT number: <strong>BE0793838003</strong>
                </p>

                <p>
                    Website developed and maintained by
                    <a href="https://vanmalderstudio.be/en" target="_blank" rel="noopener noreferrer">VanMalderStudio</a>.
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

.privacy-updated {
    color: var(--color-text-light);
    font-size: 0.875rem;
    margin-bottom: 2rem;
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

.privacy-policy-wrap strong {
    color: var(--color-text);
}

.privacy-divider {
    border: 0;
    border-top: 1px solid rgba(16, 32, 47, 0.12);
    margin: 2.5rem 0 1.5rem;
}
</style>
@endpush
@endsection
```
