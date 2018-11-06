<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name = "Mohamed Sobhy";
    public $address = "address@mail.com";
    public $subject = "this is subject";
    public $pass;
    public $url = url('/');
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pass)
    {
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('emails.login');
        return $this->markdown('emails.orders.shipped')
                ->cc($this->address, $this->name)
                ->bcc($this->address, $this->name)
                ->replyTo($this->address, $this->name)
                ->subject($this->subject);
    }
}
