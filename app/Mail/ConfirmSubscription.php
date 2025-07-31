<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmSubscription extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public string $url)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Confirm your subscription.');
    }

    public function content(): Content
    {
        return new Content('mail.confirm-subscription');
    }
}
