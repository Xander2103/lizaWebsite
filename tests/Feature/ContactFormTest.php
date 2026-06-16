<?php

namespace Tests\Feature;

use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function test_valid_submission_sends_mail_and_redirects_with_success(): void
    {
        Mail::fake();

        $response = $this->from('/')->post('/contact', [
            'name'         => 'Jane Doe',
            'email'        => 'jane@example.com',
            'phone'        => '0470 00 00 00',
            'request_type' => 'Aesthetic Medicine',
            'message'      => 'I would like to book a consultation.',
            'privacy'      => '1',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('contact_success');
        $response->assertSessionDoesntHaveErrors();

        Mail::assertSent(ContactFormSubmitted::class, function (ContactFormSubmitted $mail) {
            return $mail->submission['email'] === 'jane@example.com';
        });
    }

    public function test_missing_required_fields_fails_validation(): void
    {
        Mail::fake();

        $response = $this->from('/')->post('/contact', []);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['name', 'email', 'request_type', 'message', 'privacy']);

        Mail::assertNothingSent();
    }

    public function test_invalid_email_fails_validation(): void
    {
        Mail::fake();

        $response = $this->from('/')->post('/contact', [
            'name'         => 'Jane Doe',
            'email'        => 'not-an-email',
            'request_type' => 'General Consultation',
            'message'      => 'Hello there.',
            'privacy'      => '1',
        ]);

        $response->assertSessionHasErrors(['email']);
        Mail::assertNothingSent();
    }
}
