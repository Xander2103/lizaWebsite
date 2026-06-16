<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:120'],
            'email'        => ['required', 'email', 'max:180'],
            'phone'        => ['nullable', 'string', 'max:40'],
            'request_type' => ['required', 'string', 'max:120'],
            'message'      => ['required', 'string', 'max:5000'],
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
