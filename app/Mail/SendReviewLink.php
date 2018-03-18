<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReviewLink extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    public $payload;
    
    /**
    * Create a new message instance.
    *
    * @return void
    */
    
    public function __construct($payload){
        $this->payload = $payload;
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build(){
        return $this->from('', '')
        ->subject("\xE2\xAD\x90 \xE2\xAD\x90 \xE2\xAD\x90 \xE2\xAD\x90 \xE2\xAD\x90 How many stars would you give us?")
        ->view('emails.review')
        ->text('emails.review-plain');
    }
}