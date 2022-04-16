<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface UserRepositoryInterface
{
      /**
       * Return all items.
       *
       * @return Collection
       */
    public function all(): Collection;
 
     /**
      * Create an item
      *
      * @param array $attributes
      * @return User
      */
    public function create(array $attributes): User;

     /**
      * Update an item by id
      *
      * @param array $attributes
      * @param int|User $id
      * @return boolean
      */
    public function update(array $attributes, $id): bool;

      /**
       * confirm_user in function
       *
       * @param array $attributes
       * @return bool
       */
    public function confirm_user(array $attributes);

    /**
     * verify_code function
     * 
     * @param array $attributes
     * @return bool
     */
    public function verify_code(array $attributes);
}
