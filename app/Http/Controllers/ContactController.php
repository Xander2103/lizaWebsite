<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        } catch (Throwable $e) {
            report($e);

            return redirect(self::REDIRECT)
                ->withInput()
                ->with('contact_error', 'Something went wrong sending your message. Please try again or contact us directly by phone.');
        }

        return redirect(self::REDIRECT)->with(
            'contact_success',
            config('contact.form_success_message', 'Thank you — your message has been received.')
        );
    }
}
