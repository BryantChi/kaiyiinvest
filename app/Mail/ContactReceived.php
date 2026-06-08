<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【官網聯絡表單】' . ($this->contact->subject ?: '一般詢問') . ' - ' . $this->contact->name,
            replyTo: [$this->contact->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-received',
        );
    }
}
