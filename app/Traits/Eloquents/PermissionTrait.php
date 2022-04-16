<?php

namespace App\Traits\Eloquents;
use App\Models\Role;
use App\Models\User;

trait PermissionTrait{

    /**
     *
     *  BEGIN OF ELOQUENT FUNCTIONS SECTION
     */


    public function users(){
        return $this->belongsToMany(User::class,'permission_users','permission_id','user_id')->withPivot("status")->withTimestamps();
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'permission_roles','permission_id','role_id')->withPivot("status")->withTimestamps();
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
     * Find the permission instance for the given permission slug.
     *
     * @param  string  $permission_slug
     * @return \App\Models\Permission
     */
    public function scopeFindBySlug($permission_slug)
    {
        $search_value = addslashes($permission_slug);
        return $this->where('slug', $search_value)->first();
    }

    /**
     * Find the permission instance for the given permission name.
     *
     * @param  string  $permission_name
     * @return \App\Models\Permission
     */
    public function scopeFindByName($permission_name)
    {
        $search_value = addslashes($permission_name);
        return $this->where('name', $search_value)->first();
    }

    /**
     * Find the permission instance for the given value.
     *
     * @param  string  $value
     * @return \App\Models\Permission
     */
    public function scopeFilterPermissions($value)
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
