<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $mailer;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $mailer)
    {
        $this->email = $email;
        $this->mailer = $mailer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $when = now()->addMinute();

        Mail::to($this->email)->later($when, $this->mailer);
    }
}
