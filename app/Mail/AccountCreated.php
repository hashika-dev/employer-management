<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // This variable holds the email/password info

    public function __construct($data)
    {
        $this->data = $data;
    }

   public function build()
{
    // Update this line to use a dash
    return $this->subject('Welcome to StaffFlow')
                ->view('emails.account-created'); // <--- Change underscore to dash here
}
}