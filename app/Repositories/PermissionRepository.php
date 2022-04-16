<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Eloquent\BaseRepository;

/**
 * Abstract class PermissionRepository
 * @package App\Repositories
 */
class PermissionRepository extends BaseRepository
{

    /**
     * Permission class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change variable $model or $this->permission
     * @property Permission|mixed $model;
     */
    protected $permission;

    /**
     * PermissionRepository constructor.
     * 
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

}
