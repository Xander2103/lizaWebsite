<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormConfirmation;
use App\Mail\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class ContactController extends Controller
{
    private const REDIRECT = '/#contact-form';

    public function store(Request $request): RedirectResponse
    {
        // Honeypot — bot filled the hidden field; fake success, no mail
        if (!empty($request->input('website'))) {
            return redirect(self::REDIRECT)->with(
                'contact_success',
                config('contact.form_success_message', 'Thank you — your message has been received.')
            );
        }

        // Rate limit: 2 submissions per IP per day
        $rateLimitKey = 'contact:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateLimitKey, 2)) {
            return redirect(self::REDIRECT)->with(
                'contact_error',
                'You have reached the maximum number of messages for today. Please try again tomorrow, or book directly via Doctoranytime — available 24/7.'
            );
        }

        $validator = Validator::make($request->all(), [
            'name'         => ['required', 'string', 'max:120'],
            'email'        => ['required', 'email', 'max:180'],
            'phone'        => ['nullable', 'string', 'max:40'],
            'request_type' => ['required', 'string', Rule::in(config('contact.form_request_types', []))],
            'message'      => ['required', 'string', 'min:10', 'max:2000'],
            'privacy'      => ['accepted'],
        ]);

        if ($validator->fails()) {
            return redirect(self::REDIRECT)
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            Mail::to(config('contact.email'))->send(new ContactFormSubmitted($validated));

            Mail::to($validated['email'])->send(new ContactFormConfirmation($validated));
        } catch (Throwable $e) {
            report($e);

            return redirect(self::REDIRECT)
                ->withInput()
                ->with('contact_error', 'Something went wrong sending your message. Please try again or contact us directly by phone.');
        }

        RateLimiter::hit($rateLimitKey, 86400);

        return redirect(self::REDIRECT)->with(
            'contact_success',
            config('contact.form_success_message', 'Thank you — your message has been received.')
        );
    }
}