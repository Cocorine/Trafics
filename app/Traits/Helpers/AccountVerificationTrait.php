<?php

namespace App\Traits\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait AccountVerificationTrait
{

    protected $type;

    protected $utilisateur;

    public function verify_by_phone_number($utilisateur, $message)
    {
        try {
            //code...

            /* if (config('app.env') == 'local') {
                return true;
            } */

            $message = $message;

            $this->utilisateur = $utilisateur;

            $saveto = $utilisateur->id;
            $this->utilisateur = (string)$utilisateur->phone_number;
            $this->utilisateur = "229" . $this->utilisateur;

            $api = "5617";
            $user = "ehwhlinmi";
            $password = "assurance";
            $from = "EHWLINMI AS";

            $endpoint = "http://oceanicsms.com/api/http/sendmsg.php?user=" . $user . "&password=" . $password . "&from=" . $from . "&to=" . $this->utilisateur . "&text=" . $message . "&api=" . $api;

            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', $endpoint);

            if (Str::startsWith($response->getBody(), 'ID:')) {

                $response = 'SMS envoyé au nouveau souscripteur ' . $response->getBody();
            } else if (Str::startsWith($response->getBody(), 'ERR:')) {

                $response = 'SMS non envoyé au nouveau souscripteur ' . $response->getBody();
            }

            return $response;
        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }

        /* 
            $sms = Sms::create([
                'from'      => $auth_id,
                'to'        => $saveto,
                'message'   => $message
            ]);
        
            if (Str::startsWith($response->getBody(), 'ID:')) {
                $sms->update(['sent' => true, 'response' => $response->getBody()]);
                toastr()->success('SMS envoyé au nouveau souscripteur ' . $response->getBody(), 'Succès');
            } else if (Str::startsWith($response->getBody(), 'ERR:')) {
                $sms->update(['sent' => false, 'response' => $response->getBody()]);
                toastr()->warning('SMS non envoyé au nouveau souscripteur ' . $response->getBody(), 'SMS non envoyé');
            } 
      */
    }

    public function VerifyToken($token)
    {
        try {
            $this->user = User::filterQuery('account_verification_token', $token)->first();

            if (!$this->user) throw new Exception("Token not found. Maybe no valid try again.", 404);

            if (Carbon::parse($this->user->account_verification_request_at)->addSeconds(78)->lte(Carbon::now())) throw new Exception("Token is no longer valid. Try again.", 401);

            return true;

        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

}
