<?php

use App\Http\Controllers\API\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* 
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
*/

Route::group(['middleware' => ['cors', 'json.response'], 'as' => 'api.', 'prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API'], function () {

    Route::group(['prefix' => 'auths', 'as' => 'auths.'], function () {

        
            Route::controller('AuthController')->group(function () {

                Route::post('/login','AuthController@login')->name('login');

                Route::post('/reset-password/{id?}','AuthController@reset_password')->name('reset_password');

                Route::post('/verify-user-account','AuthController@check_user_account')->name('check_user');

                Route::post('/verify-reset-code','AuthController@verify_reset_password_code')->name('verify_reset_code');

                Route::post('/confirm-user','UserController@confirm_user')->name('confirm_user');

                // Account verification
                
                    Route::post('/verify-account','AuthController@verify_account')->name('verify_account');

                    Route::post('/confirm-account-verification-access','AuthController@confirm_account_verification_access')->name('confirm_account_verification_access');

                    //Route::get('/confirm-account-message','AuthController@confirm_account_message')->name('confirm_account_message');


                // !End Account verification

                Route::group(['middleware' => ['auth:api']], function () {

                    Route::get('/get-authenticate-user-data', 'AuthController@user')->name('user');

                    Route::post('/logout','AuthController@logout')->name('logout');

                });

            }); 
       
    });

    Route::group(['middleware' => [/* 'auth:api' */]], function () {

        /**
         *
         * User's api resource routes
         */
        Route::apiResource('users', 'UserController')->names('users'); // embed all users's controller api function route

        Route::get('get-list-of-users-with-trashed', 'UserController@allWithTrashed')->name('users.all.trashed');

        Route::get('/users/{user}/destroy', 'UserController@delete')->name('users.delete');

        /* 

            Route::controller('UserController')->group(function () {

                Route::get('/delete/{user}','UserController@delete')->name('delete');

                Route::get('/get-list-of-all-users','UserController@get_list_of_all_users')->name('all-users');

                Route::post('/get-user-data','UserController@getUserData')->name('getUserData');

            });

        */

        /**
         *
         * Permission's api resource routes
         */
        Route::apiResource('permissions', 'PermissionController')->names('permissions'); // embed all permission's controller api function route

        Route::get('get-list-of-permissions-with-trashed', 'PermissionController@allWithTrashed')->name('permissions.all.trashed');

        Route::get('/permissions/{permission}/destroy', 'PermissionController@delete')->name('permissions.delete');

        /* 

            Route::controller('PermissionController')->group(['as' => 'permissions.'],function () {

                Route::get('/delete/{permission}','PermissionController@delete')->name('delete');
                Route::get('/get-list-of-all-permissions','PermissionController@get_list_of_all_permissions')->name('all-permissions');

            });

        */

        /**
         *
         * Role's api resource routes
         */
        Route::apiResource('roles', 'RoleController')->names('roles'); // embed all role's controller api function route

        Route::get('/get-list-of-roles-with-trashed', 'RoleController@allWithTrashed')->name('roles.all.trashed');

        Route::get('/roles/{role}/destroy', 'RoleController@delete')->name('roles.delete');

        /* Route::controller(RoleController::class,function () {

            Route::get('/roles/{role}/destroy', 'RoleController@delete')->name('deleteRole');

            Route::get('/get-list-of-all-with-trashed', 'allWithTrashed')->name('roles.all-roles-with-trashed');

        }); */



        /* 
            Route::controller('AppController')->group(function () {

                Route::get('/get-list-notifications','AppController@getNotifications')->name('notifications.list');

                Route::get('/get-settings','AppController@getSettings')->name('settings.list');

                Route::get('/get-settings/{setting}','AppController@getSetting')->name('settings.show');

                Route::get('/get-list-prospects','AppController@getProspects')->name('prospects.list');

                Route::post('/add-new-prospect','AppController@addProspect')->name('prospects.store');
                
            }); 
        */

        Route::group(['as' => 'trafics.', 'prefix' => 'trafics'], function () {

            Route::get('/get-list-trafics', 'TraficController@get_trafics')->name('list');

            Route::get('/get-list-of-all-trafics', 'TraficController@get_list_of_all_trafics')->name('all-trafics');

            Route::get('/find-trafic-by/{key_value}', 'TraficController@get_contrat_by')->name('show');

            Route::post('/add-new-entree', 'TraficController@store')->name('store');

            Route::post('/edit-new-entree', 'TraficController@update')->name('store');

            Route::post('/make-the-way-out', 'TraficController@makeTheWayOut')->name('mark-the-way-out');

            Route::post('/delete-new-entree', 'TraficController@delete')->name('delete');

            Route::post('/destroy-new-entree', 'TraficController@destroy')->name('destroy');
        });
    });

});
