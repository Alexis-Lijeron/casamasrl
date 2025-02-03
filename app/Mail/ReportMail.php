<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    public function content(): Content
    {
        $type = $this->data['type'];
        if ($type === 'ventas') {
            return new Content(
                view: 'emails.reportMailVenta',
                with: [
                    'content' => json_decode($this->data['content'])
                ]
            );
        } else if ($type === 'compras') {
            return new Content(
                view: 'emails.reportMailCompra',
                with: [
                    'content' => json_decode($this->data['content'])
                ]
            );
        } else if ($type === 'pagos') {
            return new Content(
                view: 'emails.reportMailPago',
                with: [
                    'content' => json_decode($this->data['content'])
                ]
            );
        } else {
            return new Content(
                view: 'emails.reportMail',
                with: [
                    'content' => json_decode($this->data['content']),
                    'type' => $this->data['type']
                ]
            );
        }
    }

    public function attachments(): array
    {
        if (!empty($this->data['file'])) {

            return [
                Attachment::fromPath(storage_path('app/pdfs/' . $this->data['file']))
            ];
        }

        return [];
    }
}
