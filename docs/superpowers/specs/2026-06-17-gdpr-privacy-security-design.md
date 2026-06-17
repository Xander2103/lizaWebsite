# GDPR / Privacy / Security Pass — Dr Sue-Liza Eta Website

**Date:** 2026-06-17  
**Scope:** Privacy policy page, GDPR-conscious contact form, honeypot spam protection, rate limiting, security headers, Google Maps click-to-load, extended test coverage.  
**Context:** Belgian medical/aesthetic website. Pre-production. Laravel 11 + Blade + Tailwind.

---

## 0. Legal Note

The privacy policy produced by this spec is **practical website copy** — not a lawyer-reviewed legal document. The wording is careful and avoids absolute claims, but the client (Dr Sue-Liza Eta) and/or a legal professional should review the final text before the site goes into production use.

---

## 1. Current State

| Area | Status |
|---|---|
| CSRF | ✅ Already on form (`@csrf`) |
| Privacy checkbox | ✅ Present, `accepted` validation |
| Blade escaping | ✅ `{{ }}` used throughout |
| Mail subject | ✅ App-controlled |
| Reply-To | ✅ Uses validated email |
| Error logging | ✅ `report($e)` — no message content logged |
| Honeypot | ❌ Missing |
| Rate limiting | ❌ Missing |
| Privacy policy page | ❌ Missing — `/privacy` route returns 404 |
| `request_type` allowlist | ❌ Only `max:120`, accepts any string |
| Message min length | ❌ No minimum |
| Security headers | ❌ None |
| Google Maps | ❌ Iframe loads immediately |

---

## 2. Privacy Policy Page

### Route
```
GET /privacy-policy
```
Added to `routes/web.php` as an inline closure:
```php
Route::get('/privacy-policy', fn() => view('pages.privacy-policy'))->name('privacy.policy');
```

### View
`resources/views/pages/privacy-policy.blade.php` extending `layouts.client`.  
Uses existing nav, footer, premium typography. Section uses `.client-section` container for consistent spacing. No new CSS classes needed beyond what exists.

### Config update
`config/contact.php` — change `privacy_link` from `/privacy` to `/privacy-policy`.

### Content outline

**Controller / Data controller**
- Dr Sue-Liza Eta, Stockel Medical Center, Avenue de Hinnisdael 3, 1150 Brussels, Belgium
- Contact: suelacie87@gmail.com

**Data collected via the contact form**
- Full name, email address, phone number (optional), selected service, message content
- Technical data: IP address may be used for rate limiting and abuse prevention; not stored beyond the current session/request

**Purpose and legal basis**
Wording must be careful — avoid stating a single absolute legal basis. Use: "depending on the context, enquiry data may be processed on the basis of:
- **Consent** — where the user has checked the consent checkbox
- **Legitimate interest** — in responding to enquiries, preventing spam/abuse, and maintaining website security
- **Steps prior to a potential appointment** — where the enquiry is a request for information ahead of a medical or aesthetic consultation"

**Medical data warning — prominent**
> The contact form is not intended for urgent medical issues. Please do not send sensitive or detailed medical information through this form. For urgent health concerns, contact a medical professional directly or call emergency services.

**Retention**
Contact enquiries will not be kept longer than necessary. As a guideline, enquiry records are retained for up to 12 months unless a care relationship or legal obligation requires longer retention.

**Data sharing**
Data is not sold. It may be processed by:
- The website hosting provider
- Email service providers used to deliver enquiries
- No other third parties receive contact form data

**Third-party services**
- **Doctoranytime** — clicking the booking link takes the user to doctoranytime.be, which operates under its own privacy policy
- **Google Maps** — the location map is only loaded if the user clicks "Load map"; loading it causes the browser to communicate with Google servers subject to Google's privacy policy
- **Instagram** — clicking the Instagram link takes the user to instagram.com, subject to Meta's privacy policy

**Cookies and tracking**
- The site uses only technically necessary session cookies (Laravel session, CSRF token)
- No analytics, advertising, or tracking cookies are used
- If Google Maps is loaded by the user, Google may set its own cookies

**User rights under GDPR**
- Right of access, rectification, erasure, restriction, objection, and portability (where applicable)
- To exercise rights: suelacie87@gmail.com
- Right to lodge a complaint with the **Belgian Data Protection Authority (Gegevensbeschermingsautoriteit)**: www.dataprotectionauthority.be

---

## 3. Contact Form GDPR Improvements

### Checkbox label update
Current: "I agree that my information may be used to respond to my enquiry."  
New: "I agree that my information may be used to respond to my enquiry. I have read the [Privacy Policy](/privacy-policy)."
- Link opens in new tab (`target="_blank" rel="noopener noreferrer"`)
- Checkbox remains `required`, unchecked by default
- Existing `@error('privacy')` display is kept

### Validation tightening (ContactController)
| Field | Current | New |
|---|---|---|
| `name` | `required\|string\|max:120` | unchanged |
| `email` | `required\|email\|max:180` | unchanged |
| `phone` | `nullable\|string\|max:40` | unchanged |
| `request_type` | `required\|string\|max:120` | add `Rule::in(config('contact.form_request_types'))` |
| `message` | `required\|string\|max:5000` | add `min:10`, change `max` to `2000` |
| `privacy` | `accepted` | unchanged |
| `website` (honeypot) | — | `nullable\|string` (checked in controller logic) |

### Honeypot field
Hidden input in `contact.blade.php`:
```html
<div aria-hidden="true" style="position:absolute;left:-9999px;opacity:0;pointer-events:none;" tabindex="-1">
    <label for="contact-website">Leave this blank</label>
    <input type="text" id="contact-website" name="website" tabindex="-1" autocomplete="off">
</div>
```
Not part of the `validate()` call. Checked separately before sending mail:
```php
if (!empty($request->input('website'))) {
    // Honeypot triggered — fake success, no mail sent
    return back()->with('contact_success', config('contact.form_success_message', '...'));
}
```

---

## 4. Rate Limiting

### RateLimiter definition
In `app/Providers/AppServiceProvider.php` `boot()`:
```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('contact', function ($request) {
    return Limit::perDay(2)->by($request->ip());
});
```

### Route
```php
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.submit')
    ->middleware('throttle:contact');
```

### 429 response
Laravel's throttle middleware redirects back on 429. Add a `ThrottleRequestsWithRedirect` approach — or override via `ContactController` catching `ThrottleRequestsException`. Simpler: add a flash handler in the controller's `store()` wrapper or handle it in `bootstrap/app.php`'s exception handler to redirect back with a friendly message.

**User-facing 429 message:**
> "You have reached the maximum number of messages for today. Please try again tomorrow, or book directly via [Doctoranytime](…) — available 24/7."

**Implementation:** Register a `renderable` in `bootstrap/app.php` exceptions closure that catches `\Illuminate\Http\Exceptions\ThrottleRequestsException` and redirects back with the friendly `contact_error` flash.

**Note on validation failures counting toward rate limit:** Laravel's `throttle` middleware runs before validation in the controller, so failed validation submissions also consume rate limit slots. At 2/day this is acceptable for this site. Document it in the note rather than adding custom per-IP success-only counting, which would require database/cache storage of additional state.

---

## 5. Security Headers Middleware

### File
`app/Http/Middleware/SecurityHeaders.php`

### Headers applied
```
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=()
```

No `Content-Security-Policy` — would require allowlisting Google Fonts, Maps, Vite assets, and inline styles. Deferred to a future pass.

### Registration
`bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        \App\Http\Middleware\SecurityHeaders::class,
    ]);
})
```

---

## 6. Google Maps Click-to-Load

### Behaviour
On page load: show a placeholder card with a "Load map" button and a brief note: "By loading the map, Google may process your data."  
On button click: replace placeholder with the real `<iframe>`.

### Implementation in `contact.blade.php`
Replace the existing `<div class="contact-map-embed"><iframe …></iframe></div>` block with:
```html
<div class="contact-map-embed contact-map-placeholder"
     id="contact-map"
     data-map-src="{{ config('contact.maps_embed_url') }}">
    <div class="contact-map-placeholder-inner">
        <p>Map not loaded yet.</p>
        <p class="contact-map-note">By loading the map, Google may process your data per their privacy policy.</p>
        <button type="button" class="btn btn-secondary contact-map-load-btn" data-map-load>
            Load map
        </button>
    </div>
</div>
```

IIFE in `@push('scripts')` inside `contact.blade.php`:
```javascript
(function () {
    var wrap = document.getElementById('contact-map');
    if (!wrap) return;
    var btn = wrap.querySelector('[data-map-load]');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var iframe = document.createElement('iframe');
        iframe.src = wrap.dataset.mapSrc;
        iframe.width = '100%'; iframe.height = '100%';
        iframe.style.border = '0';
        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('loading', 'lazy');
        iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
        iframe.title = 'Map — {{ config("contact.location_name") }}';
        wrap.classList.remove('contact-map-placeholder');
        wrap.innerHTML = '';
        wrap.appendChild(iframe);
    });
}());
```

### CSS
`.contact-map-placeholder` — same dimensions as `.contact-map-embed`, warm background matching site palette, centered content, subtle border. Added to `client-site.css`.

---

## 7. Tests — `tests/Feature/ContactFormTest.php`

| Test | Method | Assertion |
|---|---|---|
| Privacy policy page loads | `GET /privacy-policy` | 200, sees "Privacy Policy" |
| Privacy policy mentions medical data warning | `GET /privacy-policy` | sees "urgent" |
| Form rejects missing name | POST with name empty | 422 / redirect with error |
| Form rejects invalid request_type | POST with `request_type=hack` | redirect with error |
| Form rejects short message | POST with `message=Hi` | redirect with error |
| Form rejects unchecked privacy | POST without `privacy` | redirect with error |
| Honeypot suppresses mail | POST with `website=bot` | success flash, Mail::assertNothingSent |
| Valid submission sends mail | POST with all valid fields | 302, Mail::assertSent |
| Rate limit blocks after 2 submissions | 3 valid POSTs same IP | 3rd redirects with contact_error |

---

## 8. Files Changed / Created

| File | Action |
|---|---|
| `routes/web.php` | Add `/privacy-policy` route; add `throttle:contact` middleware to `/contact` POST |
| `config/contact.php` | Change `privacy_link` to `/privacy-policy` |
| `app/Providers/AppServiceProvider.php` | Register `contact` RateLimiter |
| `bootstrap/app.php` | Register `SecurityHeaders` middleware; register 429 redirect handler |
| `app/Http/Middleware/SecurityHeaders.php` | New file |
| `app/Http/Controllers/ContactController.php` | Honeypot check; tighter validation; import `Rule` |
| `resources/views/pages/privacy-policy.blade.php` | New file |
| `resources/views/sections/contact.blade.php` | Checkbox label; honeypot field; Maps click-to-load |
| `resources/css/client-site.css` | `.contact-map-placeholder` styles |
| `tests/Feature/ContactFormTest.php` | New file |

---

## 9. Out of Scope for This Pass

- Cookie consent banner (no tracking cookies currently used)
- CSP headers (requires separate audit of all script/style/frame sources)
- Database storage of enquiries
- Email queue / job dispatch
- Admin panel for viewing submissions
