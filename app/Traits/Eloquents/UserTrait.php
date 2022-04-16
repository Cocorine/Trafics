<?php

namespace App\Traits\Eloquents;

use App\Models\Permission;
use App\Models\Role;

trait UserTrait{


    /* public function role(){
        return $this->roles()->wherePivot('status',true)->first();
    } */


    public function role() {

        return $this->roles->wherePivot('status', true)->first();
    }

    /**
     *
     *  BEGIN OF ELOQUENT FUNCTIONS SECTION
     */


    /* public function roles(){
        return $this->belongsToMany(Role::class,'role_users','user_id','role_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_users','user_id','permission_id');
    } */

    /**
     *
     *  END OF ELOQUENT SECTION
     */


    /**
     *
     *  BEGIN OF SCOPE FUNCTIONS SECTION
     */

    /**
     * Find user by attribute.
     *
     * @param  Builder  $query
     * @param  string  $attribute
     * @param  string  $value
     * @return \App\Models\User
     */
    public function scopeFilterQuery($query,$attribute, $value)
    {
        return $query->where($attribute, $value)->get();
    }

    /**
     *
     *  END OF SCOPE SECTION
     */


    /**
     *
     *  BEGIN OF QUERIES FUNCTIONS SECTION
     */

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


     /**
     *
     *  END OF QUERIES SECTION
     */
    
}
