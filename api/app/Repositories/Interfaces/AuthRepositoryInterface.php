<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

/**
 * Interface AuthRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface AuthRepositoryInterface
{
 
     /**
      * Logged in function
      *
      * @param array $attributes
      * @return mixed
      */
    public function login(array $attributes);
 
      /**
       * check_user_account function
       *
       * @param array $attributes
       * @return bool
       */
    public function check_user_account(array $attributes);
 
      /**
       * Reset password in function
       *
       * @param array $attributes
       * @return mixed
       */
    public function reset_password(array $attributes,$id);
 
      /**
       * Log user out function
       *
       * @return bool
       */
    public function logout();
 
      /**
       * Get authenticate user information
       *
       * @return User
       */
    public function user();

    /**
     * verify_reset_password_code function
     * 
     * @param array $attributes
     * @return bool
     */
    public function verify_reset_password_code(array $attributes);

    /**
     * verify_account function
     * 
     * @param array $attributes
     * @return bool
     */
    public function verify_account(array $attributes);

    /**
     * confirm_account_verification_access function
     * 
     * @param array $attributes
     * @return bool
     */
    public function confirm_account_verification_access(array $attributes);   
    
}
