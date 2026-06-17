# GDPR / Privacy / Security Pass — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a privacy policy page, harden the contact form with honeypot + strict validation, add rate limiting with a user-friendly 429, add security headers, and replace the Google Maps iframe with a click-to-load pattern.

**Architecture:** Five self-contained tasks — each adds one capability, writes its tests first, then implements, then commits. Tasks 1–4 are pure PHP/Blade; Task 5 is CSS + JS in the contact section. No new packages required; all capabilities use Laravel 11 built-ins.

**Tech Stack:** Laravel 11, Blade, Tailwind v4, PHPUnit feature tests. No new Composer dependencies.

## Global Constraints

- All Blade output uses `{{ }}` (escaped) — never `{!! !!}` for user-supplied content.
- Mail subject is app-controlled — never raw user input.
- Honeypot-triggered requests return fake success and **do not send mail** — no exception, no log entry beyond what Laravel already does.
- Rate limit message is plain text (flash is rendered with `{{ }}`); must mention Doctoranytime as alternative.
- No CSP headers — would break Google Fonts, Maps embeds, and Vite assets.
- `privacy_link` config key already exists in `config/contact.php` — update its value, do not add a new key.
- Privacy policy wording is practical copy, not a legal guarantee — prominent note must appear at the top of the page.

---

## File Map

| File | Action | Responsibility |
|---|---|---|
| `routes/web.php` | Modify | Add `GET /privacy-policy` route; add `throttle:contact` to POST `/contact` |
| `config/contact.php` | Modify | Change `privacy_link` value from `/privacy` to `/privacy-policy` |
| `app/Providers/AppServiceProvider.php` | Modify | Register `contact` RateLimiter (2 per day per IP) |
| `bootstrap/app.php` | Modify | Register `SecurityHeaders` middleware; register 429 renderable handler |
| `app/Http/Middleware/SecurityHeaders.php` | Create | Set X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy |
| `app/Http/Controllers/ContactController.php` | Modify | Honeypot check before validation; tighten `request_type` and `message` rules |
| `resources/views/pages/privacy-policy.blade.php` | Create | Full privacy policy page using `layouts.client` |
| `resources/views/sections/contact.blade.php` | Modify | Update checkbox label; add honeypot field; replace iframe with click-to-load |
| `resources/css/client-site.css` | Modify | Add `.contact-map-placeholder` and `.contact-map-placeholder-inner` styles |
| `tests/Feature/ContactFormTest.php` | Create | Privacy page, form validation, honeypot, rate limit, valid submission tests |

---

## Task 1: Privacy Policy Page

**Files:**
- Create: `resources/views/pages/privacy-policy.blade.php`
- Modify: `routes/web.php`
- Modify: `config/contact.php`
- Test: `tests/Feature/ContactFormTest.php` (first section)

**Interfaces:**
- Produces: named route `privacy.policy` consumed by Task 3 (checkbox link)

- [ ] **Step 1: Create the test file with privacy policy assertions**

Create `tests/Feature/ContactFormTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        cache()->flush(); // reset rate limiter between tests
    }

    // ── Privacy policy ─────────────────────────────────────────

    public function test_privacy_policy_page_loads(): void
    {
        $this->get('/privacy-policy')->assertStatus(200);
    }

    public function test_privacy_policy_contains_controller_name(): void
    {
        $this->get('/privacy-policy')->assertSee('Dr Sue-Liza Eta');
    }

    public function test_privacy_policy_contains_medical_warning(): void
    {
        $this->get('/privacy-policy')->assertSee('urgent');
    }

    public function test_privacy_policy_contains_legal_review_note(): void
    {
        $this->get('/privacy-policy')->assertSee('legal');
    }

    // ── Helpers ────────────────────────────────────────────────

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'         => 'Jane Dupont',
            'email'        => 'jane@example.com',
            'phone'        => '',
            'request_type' => 'Vascular Surgery',
            'message'      => 'I would like to book a vascular consultation.',
            'privacy'      => '1',
            'website'      => '',
        ], $overrides);
    }
}
```

- [ ] **Step 2: Run privacy tests to confirm they fail**

```bash
php artisan test --filter ContactFormTest::test_privacy_policy_page_loads
```
Expected: **FAIL** — "Expected response status code [200] but received [404]."

- [ ] **Step 3: Add the privacy-policy route to `routes/web.php`**

```php
<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/privacy-policy', fn() => view('pages.privacy-policy'))
    ->name('privacy.policy');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
```

- [ ] **Step 4: Update `config/contact.php` — change `privacy_link`**

Find this line:
```php
'privacy_link'  => '/privacy',
```
Change to:
```php
'privacy_link'  => '/privacy-policy',
```

- [ ] **Step 5: Create `resources/views/pages/privacy-policy.blade.php`**

```blade
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
```

- [ ] **Step 6: Run privacy tests — expect pass**

```bash
php artisan view:clear && php artisan test --filter "ContactFormTest::test_privacy"
```
Expected: 4 tests pass.

- [ ] **Step 7: Commit**

```bash
git add routes/web.php config/contact.php resources/views/pages/privacy-policy.blade.php tests/Feature/ContactFormTest.php
git commit -m "feat: add privacy policy page at /privacy-policy"
```

---

## Task 2: Security Headers Middleware

**Files:**
- Create: `app/Http/Middleware/SecurityHeaders.php`
- Modify: `bootstrap/app.php`
- Test: `tests/Feature/ContactFormTest.php` (append)

**Interfaces:**
- Produces: headers on every web response, consumed by browser security checks

- [ ] **Step 1: Append security header tests to `ContactFormTest.php`**

Add inside the class, after the privacy policy tests:

```php
// ── Security headers ───────────────────────────────────────

public function test_response_has_x_content_type_options_header(): void
{
    $this->get('/')->assertHeader('X-Content-Type-Options', 'nosniff');
}

public function test_response_has_x_frame_options_header(): void
{
    $this->get('/')->assertHeader('X-Frame-Options', 'SAMEORIGIN');
}

public function test_response_has_referrer_policy_header(): void
{
    $this->get('/')->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
}
```

- [ ] **Step 2: Run header tests — expect fail**

```bash
php artisan test --filter "ContactFormTest::test_response_has"
```
Expected: 3 failures — "Response does not have header [X-Content-Type-Options]."

- [ ] **Step 3: Create `app/Http/Middleware/SecurityHeaders.php`**

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        return $response;
    }
}
```

- [ ] **Step 4: Register middleware in `bootstrap/app.php`**

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

- [ ] **Step 5: Run header tests — expect pass**

```bash
php artisan test --filter "ContactFormTest::test_response_has"
```
Expected: 3 tests pass.

- [ ] **Step 6: Commit**

```bash
git add app/Http/Middleware/SecurityHeaders.php bootstrap/app.php tests/Feature/ContactFormTest.php
git commit -m "feat: add security headers middleware (nosniff, SAMEORIGIN, referrer-policy)"
```

---

## Task 3: Contact Form Hardening

**Files:**
- Modify: `app/Http/Controllers/ContactController.php`
- Modify: `resources/views/sections/contact.blade.php`
- Test: `tests/Feature/ContactFormTest.php` (append)

**Interfaces:**
- Consumes: named route `privacy.policy` from Task 1
- Produces: validated, honeypot-checked form endpoint consumed by Task 4 (rate limiting)

- [ ] **Step 1: Append form validation and honeypot tests to `ContactFormTest.php`**

Add after the security header tests:

```php
// ── Form validation ────────────────────────────────────────

public function test_contact_form_requires_name(): void
{
    $this->post('/contact', $this->validPayload(['name' => '']))
        ->assertSessionHasErrors('name');
}

public function test_contact_form_requires_valid_email(): void
{
    $this->post('/contact', $this->validPayload(['email' => 'not-an-email']))
        ->assertSessionHasErrors('email');
}

public function test_contact_form_rejects_invalid_request_type(): void
{
    $this->post('/contact', $this->validPayload(['request_type' => 'hack_attempt']))
        ->assertSessionHasErrors('request_type');
}

public function test_contact_form_accepts_valid_request_type(): void
{
    Mail::fake();

    $this->post('/contact', $this->validPayload(['request_type' => 'Aesthetic Medicine']))
        ->assertSessionHas('contact_success');
}

public function test_contact_form_rejects_message_too_short(): void
{
    $this->post('/contact', $this->validPayload(['message' => 'Hi']))
        ->assertSessionHasErrors('message');
}

public function test_contact_form_rejects_message_too_long(): void
{
    $this->post('/contact', $this->validPayload(['message' => str_repeat('a', 2001)]))
        ->assertSessionHasErrors('message');
}

public function test_contact_form_requires_privacy_checkbox(): void
{
    $payload = $this->validPayload();
    unset($payload['privacy']);

    $this->post('/contact', $payload)
        ->assertSessionHasErrors('privacy');
}

// ── Honeypot ───────────────────────────────────────────────

public function test_honeypot_suppresses_mail_and_returns_fake_success(): void
{
    Mail::fake();

    $this->post('/contact', $this->validPayload(['website' => 'http://spam.example.com']))
        ->assertRedirect()
        ->assertSessionHas('contact_success');

    Mail::assertNothingSent();
}

// ── Valid submission ───────────────────────────────────────

public function test_valid_submission_sends_mail(): void
{
    Mail::fake();

    $this->post('/contact', $this->validPayload())
        ->assertRedirect()
        ->assertSessionHas('contact_success');

    Mail::assertSent(ContactFormSubmitted::class);
}
```

- [ ] **Step 2: Run new tests — expect failures**

```bash
php artisan test --filter ContactFormTest::test_contact_form_rejects_invalid_request_type
php artisan test --filter ContactFormTest::test_honeypot_suppresses_mail
```
Expected: both fail — invalid type passes (no allowlist), honeypot sends mail.

- [ ] **Step 3: Replace `ContactController.php`**

```php
<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Honeypot — bot filled the hidden field; fake success, no mail
        if (!empty($request->input('website'))) {
            return back()->with(
                'contact_success',
                config('contact.form_success_message', 'Thank you — your message has been received.')
            );
        }

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:120'],
            'email'        => ['required', 'email', 'max:180'],
            'phone'        => ['nullable', 'string', 'max:40'],
            'request_type' => ['required', 'string', Rule::in(config('contact.form_request_types', []))],
            'message'      => ['required', 'string', 'min:10', 'max:2000'],
            'privacy'      => ['accepted'],
        ]);

        try {
            Mail::to(config('contact.email'))->send(new ContactFormSubmitted($validated));
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('contact_error', 'Something went wrong sending your message. Please try again or contact us directly by phone.');
        }

        return back()->with(
            'contact_success',
            config('contact.form_success_message', 'Thank you — your message has been received.')
        );
    }
}
```

- [ ] **Step 4: Update the contact form Blade — checkbox label and honeypot field**

In `resources/views/sections/contact.blade.php`, replace the checkbox block:

```html
{{-- OLD --}}
<div class="form-checkbox">
    <input type="checkbox" id="contact-privacy" name="privacy" required>
    <label for="contact-privacy">
        I agree that my information may be used to respond to my enquiry.
        @if(!empty(config('contact.privacy_link')))
            <a href="{{ config('contact.privacy_link') }}" target="_blank" rel="noopener noreferrer">Privacy policy</a>.
        @endif
    </label>
    @error('privacy')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>
```

Replace with:

```html
{{-- Honeypot: hidden from real users, bots fill it --}}
<div aria-hidden="true" style="position:absolute;left:-9999px;opacity:0;pointer-events:none;tab-index:-1;">
    <label for="contact-website">Leave this blank</label>
    <input type="text" id="contact-website" name="website" tabindex="-1" autocomplete="off">
</div>

<div class="form-checkbox">
    <input type="checkbox" id="contact-privacy" name="privacy" value="1" required>
    <label for="contact-privacy">
        I agree that my information may be used to respond to my enquiry.
        I have read the <a href="{{ route('privacy.policy') }}" target="_blank" rel="noopener noreferrer">Privacy Policy</a>.
    </label>
    @error('privacy')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>
```

- [ ] **Step 5: Run all form hardening tests**

```bash
php artisan view:clear && php artisan test --filter ContactFormTest
```
Expected: all previously written tests pass (privacy, headers, validation, honeypot, valid submission).

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/ContactController.php resources/views/sections/contact.blade.php tests/Feature/ContactFormTest.php
git commit -m "feat: harden contact form — honeypot, request_type allowlist, message min/max, privacy link"
```

---

## Task 4: Rate Limiting

**Files:**
- Modify: `app/Providers/AppServiceProvider.php`
- Modify: `routes/web.php`
- Modify: `bootstrap/app.php`
- Test: `tests/Feature/ContactFormTest.php` (append)

**Interfaces:**
- Consumes: `throttle:contact` named limiter registered in AppServiceProvider
- Produces: 429 redirect with user-friendly `contact_error` flash message

- [ ] **Step 1: Append rate limit test to `ContactFormTest.php`**

Add after the valid submission test:

```php
// ── Rate limiting ──────────────────────────────────────────

public function test_rate_limit_blocks_after_two_submissions(): void
{
    Mail::fake();

    $payload = $this->validPayload();

    // First two submissions succeed
    $this->post('/contact', $payload)->assertSessionHas('contact_success');
    $this->post('/contact', $payload)->assertSessionHas('contact_success');

    // Third is rate-limited — must redirect back with contact_error
    $this->post('/contact', $payload)
        ->assertRedirect()
        ->assertSessionHas('contact_error');
}
```

- [ ] **Step 2: Run rate limit test — expect fail**

```bash
php artisan test --filter ContactFormTest::test_rate_limit_blocks_after_two_submissions
```
Expected: FAIL — third submission succeeds (no rate limit yet).

- [ ] **Step 3: Register the `contact` RateLimiter in `AppServiceProvider.php`**

```php
<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        RateLimiter::for('contact', function ($request) {
            return Limit::perDay(2)->by($request->ip());
        });
    }
}
```

- [ ] **Step 4: Add `throttle:contact` to the contact route in `routes/web.php`**

```php
<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/privacy-policy', fn() => view('pages.privacy-policy'))
    ->name('privacy.policy');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.submit')
    ->middleware('throttle:contact');
```

- [ ] **Step 5: Add the 429 exception handler to `bootstrap/app.php`**

The handler catches `ThrottleRequestsException` for the contact route and redirects back with a friendly plain-text message that mentions Doctoranytime. The Doctoranytime booking card is already visible right next to the form, so the user can act on it immediately.

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (ThrottleRequestsException $e, $request) {
            if ($request->routeIs('contact.submit')) {
                return redirect()->back()->with(
                    'contact_error',
                    'You have reached the maximum number of messages for today. Please try again tomorrow, or book directly via Doctoranytime — available 24/7.'
                );
            }
        });
    })->create();
```

- [ ] **Step 6: Run rate limit test — expect pass**

```bash
php artisan test --filter ContactFormTest::test_rate_limit_blocks_after_two_submissions
```
Expected: PASS.

- [ ] **Step 7: Run the full test suite**

```bash
php artisan test --filter ContactFormTest
```
Expected: all tests pass. Also run existing tests:
```bash
php artisan test --filter HomepageTest
```
Expected: all 16 pass.

- [ ] **Step 8: Commit**

```bash
git add app/Providers/AppServiceProvider.php routes/web.php bootstrap/app.php tests/Feature/ContactFormTest.php
git commit -m "feat: rate limit contact form (2/day per IP) with user-friendly 429 redirect"
```

---

## Task 5: Google Maps Click-to-Load

**Files:**
- Modify: `resources/views/sections/contact.blade.php`
- Modify: `resources/css/client-site.css`

**Interfaces:**
- No PHP changes — pure HTML/CSS/JS in one Blade partial
- The existing `.contact-map-embed` CSS class (`height: 240px`, `rounded-xl`, `overflow-hidden`, `mt-3 mb-3`) must be matched by the placeholder

**Note:** This task has no automated test (no server-side logic). Manual verification: run `npm run build`, load the page in a browser, confirm the placeholder renders and the map loads on button click.

- [ ] **Step 1: Add `.contact-map-placeholder` CSS to `client-site.css`**

Find this block in `client-site.css`:
```css
  .contact-map-embed {
      @apply rounded-xl overflow-hidden mt-3 mb-3;
      height: 240px;
  }
```

Add immediately after it:

```css
  /* Click-to-load placeholder — same dimensions as .contact-map-embed */
  .contact-map-placeholder {
      @apply flex flex-col items-center justify-center rounded-xl mt-3 mb-3;
      height: 240px;
      background-color: var(--color-bg-alt);
      border: 1px solid var(--color-border);
      text-align: center;
      padding: 1rem;
      gap: 0.625rem;
  }

  .contact-map-placeholder-inner {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.5rem;
  }

  .contact-map-placeholder-inner p {
      @apply text-sm m-0;
      color: var(--color-text-light);
  }

  .contact-map-note {
      font-size: 0.75rem !important;
      max-width: 22rem;
  }
```

Also find this line in the mobile `@media (max-width: 767px)` block:
```css
    .contact-map-embed     { height: 160px; }
```
Change to:
```css
    .contact-map-embed,
    .contact-map-placeholder { height: 160px; }
```

- [ ] **Step 2: Replace the Google Maps iframe block in `contact.blade.php`**

Find this block:
```html
@if(!empty(config('contact.maps_embed_url')))
    <div class="contact-map-embed">
        <iframe
            src="{{ config('contact.maps_embed_url') }}"
            width="100%" height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Map — {{ config('contact.location_name') }}"
        ></iframe>
    </div>
@endif
```

Replace with:
```html
@if(!empty(config('contact.maps_embed_url')))
    <div class="contact-map-placeholder"
         id="contact-map"
         data-map-src="{{ config('contact.maps_embed_url') }}"
         data-map-title="Map — {{ config('contact.location_name') }}">
        <div class="contact-map-placeholder-inner">
            <p>Map not loaded.</p>
            <p class="contact-map-note">By loading the map, Google may process your data per their privacy policy.</p>
            <button type="button" class="btn btn-secondary" data-map-load style="padding-top:0.5rem; padding-bottom:0.5rem; font-size:0.8125rem;">
                Load map
            </button>
        </div>
    </div>
@endif
```

- [ ] **Step 3: Add the click-to-load IIFE inside `contact.blade.php`**

Add a `@push('scripts')` block at the very end of `contact.blade.php`, after the closing `</section>` tag:

```html
@push('scripts')
<script>
(function () {
    var wrap = document.getElementById('contact-map');
    if (!wrap) return;
    var btn = wrap.querySelector('[data-map-load]');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var iframe = document.createElement('iframe');
        iframe.src = wrap.dataset.mapSrc;
        iframe.width = '100%';
        iframe.height = '100%';
        iframe.style.border = '0';
        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('loading', 'lazy');
        iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
        iframe.title = wrap.dataset.mapTitle;
        wrap.classList.remove('contact-map-placeholder');
        wrap.innerHTML = '';
        wrap.appendChild(iframe);
    });
}());
</script>
@endpush
```

- [ ] **Step 4: Build and verify manually**

```bash
php artisan view:clear && npm run build
```
Expected: clean build, no errors.

Open the site in a browser. Navigate to the contact section. Confirm:
- Map placeholder is visible (warm background, "Load map" button)
- Google Maps iframe is **not** loading on page load (check Network tab — no `maps.googleapis.com` requests)
- Clicking "Load map" loads the iframe and replaces the placeholder
- The placeholder matches the surrounding card styling

- [ ] **Step 5: Commit**

```bash
git add resources/views/sections/contact.blade.php resources/css/client-site.css
git commit -m "feat: replace Google Maps iframe with privacy-friendly click-to-load placeholder"
```

---

## Task 6: Final Verification

- [ ] **Step 1: Run the complete test suite**

```bash
php artisan view:clear && php artisan test
```
Expected output:
```
Tests:  XX passed
```
All `HomepageTest` (16) and all `ContactFormTest` tests pass. Zero failures.

- [ ] **Step 2: Build assets**

```bash
npm run build
```
Expected: clean build, no warnings about missing CSS classes.

- [ ] **Step 3: Final commit if any loose files remain**

```bash
git status
```
If any files are uncommitted (e.g., minor fixups made during verification), commit them:
```bash
git add -p
git commit -m "fix: final cleanup after GDPR/privacy/security pass"
```

---

## Summary of Changes

| Area | What changed |
|---|---|
| Privacy policy | New page at `/privacy-policy` with practical GDPR-conscious content and prominent legal review note |
| Privacy link | Updated in `config/contact.php` from `/privacy` to `/privacy-policy`; checkbox uses named route |
| Checkbox label | Now reads "I have read the Privacy Policy" with working link |
| Honeypot | Hidden `website` field; controller silently returns fake success if non-empty |
| Validation | `request_type` restricted to configured values via `Rule::in`; `message` now `min:10 max:2000` |
| Rate limiting | 2 POST per day per IP; 429 redirects back with plain-text Doctoranytime suggestion |
| Security headers | `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy` on all web responses |
| Google Maps | Click-to-load; no Google connection until user clicks "Load map"; privacy note visible |

## Out of Scope

- CSP headers (deferred — requires audit of all script/style/frame sources)
- Cookie consent banner (no tracking cookies used)
- Database storage of enquiries
- Admin panel / submission log
