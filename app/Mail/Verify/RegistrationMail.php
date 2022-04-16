<?php

namespace App\Mail\Verify;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $details = $this->details;
        
        return $this->from(config('mail.mailers.smtp.username'), config('mail.mailers.smtp.from'))->subject("Confirmation du compte")->view('emails.verify.registration_verification',compact('details'));

    }
}
