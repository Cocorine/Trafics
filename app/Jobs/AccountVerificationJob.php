<?php

namespace App\Jobs;

use App\Mail\Verify\RegistrationMail;
use App\Mail\Verify\ResetPasswordMail;
use App\Models\User;
use App\Traits\Helpers\AccountVerificationTrait;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, AccountVerificationTrait;

    protected $channel;
    protected $type;
    protected $message;
    protected User $receiver;
    protected $auth_id;
    private $initTimer = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($channel,$type, User $receiver, $message)
    {
        
        $this->queue = 'notifications';
        $this->message = $message;
        $this->type = $type;
        $this->channel = $channel;
        $this->receiver = $receiver;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->channel == 'phone_number') {

            return $this->verify_by_phone_number($this->receiver, "Votre code de vérification : ".$this->message);

        } elseif ($this->channel == 'email') {

            $details = [];

            if ($this->type == 'registration') {
                
                $details['code'] = $this->receiver->account_verification_code;

                //$details['url'] = env('APP_URL')."/account_activation/". Hash::make($this->receiver->account_verification_code);

                $email = new RegistrationMail($this->details) ;

            }

            elseif ($this->type == 'reset_password'){

                $details['code'] = $this->receiver->reset_password_code;

                $details['url'] = env('APP_URL')."/reset_password/account_verification/". Hash::make($this->receiver->account_verification_code);
                
                $email = new ResetPasswordMail($details) ;
                
            }

            else $email = null;

            $when = now()->addMinute($this->initTimer);

            try {

                Mail::to($this->receiver->email)->later($when, $email);

            } catch (\Throwable $th) {

                $message = $th->getMessage();

                throw new Exception($message, 500);
                
            }

        }
    }
}
