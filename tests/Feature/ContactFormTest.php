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
