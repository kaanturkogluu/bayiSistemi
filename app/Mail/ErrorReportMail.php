<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ErrorReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $description;
    public $user;
    public $screenshotPath;

    /**
     * Create a new message instance.
     */
    public function __construct($description, $user, $screenshotPath = null)
    {
        $this->description = $description;
        $this->user = $user;
        $this->screenshotPath = $screenshotPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hata Bildirimi - ' . ($this->user->name ?? $this->user->username ?? 'Misafir'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.error_report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->screenshotPath && file_exists($this->screenshotPath)) {
            return [
                Attachment::fromPath($this->screenshotPath)
                    ->as('ekran-goruntusu.' . (pathinfo($this->screenshotPath, PATHINFO_EXTENSION) ?: 'png'))
            ];
        }

        return [];
    }
}
