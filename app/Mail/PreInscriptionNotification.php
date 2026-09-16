<?php

namespace App\Mail;

use App\Models\PreInscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PreInscriptionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PreInscription $inscription)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle pré-inscription — Girona de Saly',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pre-inscription',
        );
    }
}
