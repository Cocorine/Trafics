<?php

namespace App\Traits\Eloquents;
use App\Models\Permission;
use App\Models\User;

trait RoleTrait{

    /**
     *
     *  BEGIN OF ELOQUENT FUNCTIONS SECTION
     */


    public function users(){
        return $this->belongsToMany(User::class,'role_users','role_id','user_id')->withPivot("status")->withTimestamps();
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_roles','role_id','permission_id')->withPivot("status")->withTimestamps();
    }

    /**
     *
     *  END OF ELOQUENT SECTION
     */



    /**
     *
     *  BEGIN OF SCOPE FUNCTIONS SECTION
     */


    /**
     * Find the role instance for the given role slug.
     *
     * @param  string  $role_slug
     * @return \App\Models\Role
     */
    public function scopeFindBySlug($role_slug)
    {
        $search_value = addslashes($role_slug);
        return $this->where('slug', $search_value)->first();
    }

    /**
     * Find the role instance for the given role name.
     *
     * @param  string  $role_name
     * @return \App\Models\Role
     */
    public function scopeFindByName($role_name)
    {
        $search_value = addslashes($role_name);
        return $this->where('name', $search_value)->first();
    }

    /**
     * Find the role instance for the given value.
     *
     * @param  string  $value
     * @return \App\Models\Role
     */
    public function scopeFilterRoles($value)
    {
        $search_value = addslashes($value);
        return $this->where('name', 'LIKE', '%'. $search_value . '%')
                    ->orWhere('slug', 'LIKE', '%' . $search_value . '%');
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
     *
     *  END OF QUERIES SECTION
     */
}
