<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Eloquents\HasPermissionsTrait;
use App\Traits\Eloquents\UserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasPermissionsTrait, UserTrait, HasApiTokens, HasFactory, Notifiable, SoftDeletes;// trait function importation

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table='users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey='id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'phone_number',
        'username',
        'profession',
        'email',
        'password',
    ];

    protected $with = ['roles','permissions'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
        'phone_number' => 'integer',
    ];

    protected $username = 'username';

    # Accessors & Mutators

    
    /**
     * Get the user's short full name.
     *
     * @return string
     */
    public function getShortFullNameAttribute()
    {
        $myvalue = $this->last_name;
        $arr = explode(' ', trim($myvalue));
        return "{$this->first_name} {$arr[0]}";
    }

    /**
     * Get the user's last name.
     *
     * @param  string  $value
     * @return string
     */
    public function getLastNameAttribute($value)
    {
        return ucfirst(str_replace('\\', ' ', $value)); // Converts user's last name to uppercase
    }

    /**
     * Set the user's last name.
     *
     * @param  string  $value
     * @return void
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = addslashes($value); // Escape value with backslashes
    }


    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return ucwords(str_replace('\\', ' ', $value)); // Converts the first character of user's last name to uppercase
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = addslashes($value); // Escape value with backslashes
    }


    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    /**
     * Get the user's username.
     *
     * @param  string  $value
     * @return string
     */
    public function getUsernameAttribute($value)
    {
        return strtolower(str_replace('\\', ' ', $value)); // Converts the username to lower
    }

    /**
     * Set the user's username.
     *
     * @param  string  $value
     * @return void
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = addslashes($value); // Escape value with backslashes
    }

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

}
