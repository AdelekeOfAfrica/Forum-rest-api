<?php

namespace App\Mail;

use App\Models\book;
use App\Models\User;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMarkDownMail extends Mailable
{
    use Queueable, SerializesModels;
   
    public book $book;
   

    /**
     * Create a new message instance.
     */
    public function __construct( book $book )
    {
        //

        $this->book =$book;

     
   
    
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'getting content froom database ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
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
