<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $email_details;
    public $subject;
    
    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct($email_details, $subject = "Your account password")
    {
        $this->email_details = $email_details;
        $this->subject = $subject;
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        return $this->from('', '')
        ->subject($this->subject)
        ->view('emails.password')
        ->text('emails.password-plain');
    }
}