<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $customer;

    /**
     * Create a new message instance.
     */
    public function __construct(public $data)
    {
        $this->customer = [
            'name' => $data['name'],
            'address' => $data['email'],
        ];
    }

    /**
     * Get the message envelope.
     *
     * from:    mail_from_address@example.com, Mail From Name
     * to:      customer_email@example.com, Customer Name
     * replyTo: youremail@example.com, Contact Name
     * subject: Confirmation: your message to Contact Name has been sent
     */
    public function envelope(): Envelope
    {
        $mailer = config('mail.from');
        $contact = config('mail.contact');

        return new Envelope(
            from: new Address(
                $mailer['address'],
                $mailer['name']
            ),
            to: [ new Address(
                $this->customer['address'],
                $this->customer['name']
                )
            ],
            replyTo: [ new Address(
                $contact['address'],
                $contact['name']
                )
            ],
            subject: 'Confirmation: your message to ' . $contact['name'] . ' has been sent',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.confirmation-mail',
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
