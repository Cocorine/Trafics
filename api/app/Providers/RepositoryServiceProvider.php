<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\Eloquent\EloquentRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\PermissionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(EloquentRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
