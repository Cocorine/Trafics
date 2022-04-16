<?php

use App\Mail\Verify\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/emails', function () {
    return view('emails.verify.reset_password_verification');
});
Route::get('/emails-confirm', function () {
    return view('emails.confirm.new_registration');
});

Route::get('/date', function () {

    $details['code'] = rand('23408',897087);
    //$details['url'] = env('APP_URL')."/reset_password/account_verification/". Hash::make($this->receiver->account_verification_code);

    $email = new ResetPasswordMail($details) ;
    $when = now()->addMinute(1);


    Mail::to("corinebocog@gmail.com")->later($when, $email);
});

Route::get("auth/account_verification/{user}", function ($user) {
    dd($user);
});