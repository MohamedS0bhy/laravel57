<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name = "Mohamed Sobhy";
    public $address = "address@mail.com";
    public $subject = "this is subject";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.login')
                ->cc($this->address, $this->name)
                ->bcc($this->address, $this->name)
                ->replyTo($this->address, $this->name)
                ->subject($this->subject);
    }
}