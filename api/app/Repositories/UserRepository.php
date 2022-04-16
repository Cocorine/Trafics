<?php

namespace App\Repositories;

use App\Jobs\AccountVerificationJob;
use App\Jobs\NotificationJob;
use App\Mail\Confirm\NewRegistrationMail;
use App\Models\OauthClient;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\Helpers\AccountVerificationTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

/**
 * Abstract class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
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
        parent::__construct($model);
    }

    /**
     * Create an user.
     *
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes): User
    {
        DB::beginTransaction();

        try {
            //code...
            $this->user = parent::create($attributes);

            $this->createOAuthClient($this->user); // create user registered oauth client

            $this->user->roles()->sync(isset($attributes['roles']) ? $attributes['roles'] : [1], true);

            $this->user->permissions()->sync(isset($attributes['permissions']) ? $attributes['permissions'] : [], true);

            DB::commit(); // commit all modification in database

            //$this->confirm_user(['attribute' => 'mail', 'value' => $this->user->email]);

            return $this->user;

        } catch (\Throwable $th) {

            DB::rollback(); // roll back all modification from database

            $message = $th->getMessage();

            throw new Exception($message, 500);

        }
    }

    /**
     * Create a newly oauth client for the newly user.
     *
     * @param int|Model $id
     * @return
     */
    public function createOAuthClient($user)
    {
        try {

            OauthClient::create([
                "user_id" => $user->id,
                "secret" => Str::random(40),
                "name" => $user->full_name." Password Grant Client",
                "revoked" => 0,
                "password_client" => config('passport.grant_access_client.id'),
                "personal_access_client" => 0,
                "redirect" => config('app.url'),
            ]);
            
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
    public function confirm_user(array $attributes)
    {
        try {
            
            $this->user = User::findOrfail($attributes['user_id']);
            //$this->user = User::filter($attributes['attribute'], $attributes['value'])->first();

            $this->user->account_verification_request_at = Carbon::now();
            $this->user->account_verification_gateway = $attributes['channel'];
            $this->user->account_verification_code = Str::random(60);

            $this->user->save();

            //return dispatch(new AccountVerificationJob($attributes['channel'],'registration', $this->user, ''));

            return true;
        
        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);

        }
    }

    /**
     * Update an user.
     *
     * @param array $attributes
     * @param int|User $id
     * @return boolean
     */
    public function update(array $attributes, $id): bool
    {
        DB::beginTransaction();

        try {

            parent::update($attributes, $id);

            $this->user = parent::find($id);

            $this->user->roles()->sync(isset($attributes['roles']) ? $attributes['roles'] : [1], false);

            $this->user->permissions()->sync(isset($attributes['permissions']) ? $attributes['permissions'] : [], false);

            DB::commit(); // commit all modification in database

            return true;

        } catch (\Throwable $th) {

            DB::rollback(); // roll back all modification from database

            $message = $th->getMessage();

            throw new Exception($message, 500);
        }
    }

    /**
     * Verify code in function
     *
     * @param array $attributes
     * @return bool
     */
    public function verify_code(array $attributes)
    {
        try {
            
            $this->user = User::findOrfail($attributes['user_id']);

            if( $this->user->reset_request_at->addSeconds(120)->gt(Carbon::now()) ) throw new Exception("Code invalid. Veuillez réessayer.", 401);

            if ($this->user->reset_password_code != $attributes['code'] ) throw new Exception("Code incorrect", 401);

            $this->user->account_verified_at = Carbon::now();
            $this->user->account_verification_code = null;
            $this->user->account_verified = true;

            $this->user->save();

            if($this->user->reset_password_by == 'phone_number'){
                $response = $this->verify_by_phone_number($this->user, "Bienvenue à ". ucfirst(env('APP_NAME')). " Votre compte à bien été activé, vous pouvez désormais vous connectez grâce à vos identifiant. \nBonne continuation" );
            }
            else{

                $mail = new NewRegistrationMail();

                $response = dispatch(new NotificationJob($this->user->email, $mail));

            }   
        
            return $response;

        } catch (\Throwable $th) {

            $message = $th->getMessage();

            throw new Exception($message, 500);

        }
    }
}
