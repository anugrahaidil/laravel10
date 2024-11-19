<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegisteredNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $userData;
    /**
     * Create a new message instance.
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
    }
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Pendaftaran Berhasil')
                    ->view('emails.user-registered')
                    ->with('userData', $this->userData);
    }
}
