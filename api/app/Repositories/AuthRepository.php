<?php

namespace App\Repositories;

use App\Jobs\AccountVerificationJob;
use App\Jobs\DispachingJob;
use App\Jobs\NotificationJob;
use App\Mail\Confirm\NewRegistrationMail;
use App\Mail\Confirm\PasswordResetMail;
use App\Mail\Verify\RegistrationMail;
use App\Mail\Verify\ResetPasswordMail;
use App\Models\OauthClient;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Traits\Helpers\AccountVerificationTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Abstract class UserRepository
 * @package App\Repositories
 */
class AuthRepository implements AuthRepositoryInterface
{

    use AccountVerificationTrait;

    /**
     * User class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change variable $model or $this->user
     * @property User|mixed $model;
     */
    protected $user;

    /**
     * UserRepository constructor.
     * 
     * @param User $user
     */
    public function __construct(User $model)
    {
        $this->user = $model;
    }


    /**
     * Logged in function.
     *
     * @param array $request
     * @return mixed
     */
    public function login(array $attributes)
    {
        try {

            $this->user = User::filterQuery('username', $attributes['identifiant'])->first(); // Find user by username

            if (!$this->user) throw new Exception("Identifiant incorrect", 401);

            if (!(Hash::check($attributes['password'], $this->user->password))) throw new Exception("Mot de passe incorrect", 401);

            return $this->createTokenByCredentials($attributes, $this->user);
        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * Generate authenticate token
     *
     * @param array $request
     * @param User $id
     * @return mixed
     */
    public function createTokenByCredentials(array $request, $user)
    {

        try {

            $oauth_client = OauthClient::where('user_id', $user['id'])->first();

            if ($oauth_client) {

                $authenticate = Request::create('/oauth/token', 'POST', [
                    'grant_type' => 'password',
                    'client_id' => $oauth_client->id,
                    'client_secret' => $oauth_client->secret,
                    'username' => $request['identifiant'],
                    'password' => $request['password'],
                    'scope' => '*',
                ]);
            } else {

                $authenticate = Request::create('/oauth/token', 'POST', [
                    'grant_type' => 'password',
                    'client_id' => config('passport.grant_access_client.id'),
                    'client_secret' =>  config('passport.grant_access_client.secret'),
                    'username' => $request['identifiant'],
                    'password' => $request['password'],
                    'scope' => '*',
                ]);
            }

            $response = app()->handle($authenticate)->getContent(); // authenticated user token access

            // dispacth user login event...

            //LoginHistory::dispatch($user);

            return json_decode($response);
        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * Logged in function
     *
     * @param array $attributes
     * @return bool
     */
    public function check_user_account(array $attributes)
    {
        try {

            $this->user = User::filterQuery($attributes['attribute'], $attributes['value'])->first();

            $code = rand(100000, 999999);

            $this->user->reset_request_at = Carbon::now();
            $this->user->reset_password_by = $attributes['channel'];
            $this->user->reset_password_code = $code;

            $this->user->save();

            return dispatch(new AccountVerificationJob($attributes['channel'], 'reset_password', $this->user, $code));

            return true;
        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * Logged in function
     *
     * @param array $attributes
     * @return bool
     */
    public function verify_reset_password_code(array $attributes)
    {
        try {

            $this->user = User::findOrfail($attributes['user_id']);

            if (Carbon::parse($this->user->reset_request_at)->addSeconds(240)->lte(Carbon::now())) throw new Exception("Code invalid. Veuillez réessayer.", 401);

            if ($this->user->reset_password_code != $attributes['code']) throw new Exception("Code incorrect", 401);

            return true;

        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * Reset password in function
     *
     * @param array $attributes
     * @return mixed
     */
    public function reset_password(array $attributes, $id = null)
    {
        try {

            if (Auth()->user()) {

                if (!(Hash::check($attributes['current_password'], $this->user->password))) throw new Exception("Mot de passe actuel est incorrect veuillez vérifier", 422);

                $this->user = Auth()->user();
            } else {

                $this->user = User::findOrfail($id);
            }

            if ((Hash::check($attributes['new_password'], $this->user->password))) throw new Exception("Le nouveau mot de passe doit être différent de l'actuel mot de passe. Veuillez vérifier", 422);

            $password = Hash::make($attributes['new_password']); // Hash user registered password

            $this->user->password_update_at = Carbon::now();
            $this->user->last_password_remember = $attributes['current_password'];
            $this->user->password = $password;
            $this->user->reset_password = true;
            $this->user->reset_password_code = null;

            $this->user->save();

            if ($this->user->reset_password_by == 'phone_number') {
                $response = $this->verify_by_phone_number($this->user, "Vous venez de modifier le mot de passe de votre compte \"" . env('APP_NAME') . "\"");
            } else {

                $mail = new PasswordResetMail();

                $response = dispatch(new NotificationJob($this->user->email, $mail));
            }

            return true;
        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * Logg user out function
     *
     */
    public function logout()
    {

        try {
            $accessToken = Auth::user()->token();

            if ($accessToken->revoke()) $response = true;

            else $response = true;

            DB::table('oauth_access_tokens')->where('id', $accessToken->id)->delete();

            DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->delete();

            return $response;
        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * Get authenticate user information
     * 
     * @return User
     */
    public function user()
    {
        try {

            $this->user = Auth::user();

            return $this->user;
        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * verify_reset_password_code function
     * 
     * @param array $attributes
     * @return bool
     */
    public function verify_account(array $attributes)
    {

        try {


            $this->user = User::filterQuery($attributes['attribute'], $attributes['value'])->first();

            $token = rand(100000, 999999);

            $this->user->account_verification_request_at = Carbon::now();

            $this->user->operation_name = $attributes['operation_name'];

            $this->user->account_verification_gateway = $attributes['gateway'];

            

            if ($attributes['gateway'] == 'SMS') {

                $this->user->account_verification_token = $token;

                $this->user->save();

                $message = "Votre code de vérification est : " . $token;

                $this->verify_by_phone_number($this->user, $message);

            } else {

                $this->user->account_verification_token = Hash::make($token);

                $this->user->save();

                $attributes['url'] = "/account_activation/?token=" . $this->user->account_verification_token."&mail=".$this->user->email."&id=".$this->user->id;

                $mailer = null;

                if ($attributes['operation_name'] == 'registration') $mailer = new RegistrationMail($attributes);

                else if ($attributes['operation_name'] == 'reset-password') $mailer = new ResetPasswordMail($attributes);

                dispatch(new DispachingJob($mailer, $this->user->email));
            }

            //return dispatch(new AccountVerificationJob($attributes['channel'],'reset_password', $this->user, $code));

            return true;

        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * confirm_account_verification_access function
     * 
     * @param array $attributes
     * @return bool
     */
    public function confirm_account_verification_access(array $attributes)
    {
        try {

            $this->user = User::findOrfail($attributes['user_id']);

            

            if (Carbon::parse($this->user->account_verification_request_at)->addSeconds(90)->lte(Carbon::now())) throw new Exception("Token is no longer valid. Try again.", 401);

            if ($this->user->operation_name == 'registration') {

                if (!Hash::check($this->user->account_verification_token, $attributes['token'])) throw new Exception("Token not found. Maybe no valid try again.", 404);

                $this->user->account_verified_at = Carbon::now();

                $this->user->account_verified = true;

                $this->user->account_verification_token = null;

                $this->user->operation_name = null;

                $this->user->account_verification_gateway = null;

                $this->user->save();

                $mailer = new NewRegistrationMail($attributes);

                dispatch(new DispachingJob($mailer, $this->user->email));
            }
            else{
                if ($this->user->account_verification_token != $attributes['token']) throw new Exception("Token not found. Maybe no valid try again.", 404);
            }

            return true;

        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

}
