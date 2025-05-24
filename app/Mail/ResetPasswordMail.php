<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $name;
    public $resetLink;

    public function __construct($token, $name)
    {
        $this->token = $token;
        $this->name = $name;
        $this->resetLink = route('password.reset', ['token' => $token]);
    }

    public function build()
    {
        return $this->subject('Reset Your Password')
                    ->view('emails.reset-password')
                    ->with([
                        'name' => $this->name,
                        'resetLink' => $this->resetLink
                    ]);
    }
} 