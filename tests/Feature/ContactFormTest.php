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
