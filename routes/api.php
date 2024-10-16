<?php

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

Route::post('store-log', 'ApiController@storeLog');
Route::post('store-client', 'ApiController@storeClient');
Route::post('store-contact-us', 'ApiController@storeContact');
Route::post('signup', 'ApiController@signup');
Route::post('forget-password', 'ApiController@forgetPassword');
Route::post('reset-password', 'ApiController@resetPassword');
Route::post('login', 'ApiController@login');

// Authenticated routes
Route::group(['middleware' => ['jwt.verify']], function() {
	Route::post('background-login', 'ApiController@backgroundLogin');
	Route::post('update-profile', 'ApiController@updateProfile');
	Route::post('change-password', 'ApiController@changePassword');
	Route::post('view-profile', 'ApiController@viewProfile');
	Route::post('logout', 'ApiController@logout');
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
	Route::post('register', 'PassportAuthController@register');
	Route::post('login', 'PassportAuthController@login');
	Route::post('verify-otp', 'PassportAuthController@verify_otp');
	Route::post('resend-code', 'PassportAuthController@resend_code');
	Route::post('forgot-password', 'ForgetPasswordController@sendMail');
	Route::post('verify-code', 'ForgetPasswordController@checkCode');
	Route::post('reset-password', 'ForgetPasswordController@resetPassword');
	
});