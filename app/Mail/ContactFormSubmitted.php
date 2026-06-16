<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $submission)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('New consultation enquiry — ' . config('site.name'))
            ->replyTo($this->submission['email'], $this->submission['name'])
            ->view('emails.contact-form');
    }
}
