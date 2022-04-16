<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DispachingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailer;

    protected $mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailer, $mail)
    {

        $this->mailer = $mailer;

        $this->mail = $mail;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $when = now()->addMinute();

        Mail::to($this->mail)->later($when, $this->mailer);
        
    }
}
