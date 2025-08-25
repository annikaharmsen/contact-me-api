<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    private $customer, $form_subject;

    /**
     * Create a new message instance.
     */
    public function __construct( public $data )
    {
        $this->customer = [
            'name' => $data['name'],
            'address' => $data['email']
        ];
        $this->form_subject = $data['subject'] ?? null;
    }

    /**
     * Get the message envelope.
     *
     * from:    mail_from_address@example.com, Customer Name (Contact Form)
     * to:      contact_address@example.com, Contact Name
     * replyTo: customer@example.com, Customer Name
     * subject: Form Subject
     */
    public function envelope(): Envelope
    {
        $mailer = config('mail.from');
        $contact = config('mail.contact');

        return new Envelope(
            from: new Address(
                $mailer['address'],
                 $this->customer['name'] . ' (Contact Form)'
            ),
            to: [
                new Address(
                    $contact['address'],
                    $contact['name']
                )
            ],
            replyTo: [
                new Address(
                    $this->customer['address'],
                    $this->customer['name']
                    )
                ],
            subject: $this->form_subject ?? 'Contact Form',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-form-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
