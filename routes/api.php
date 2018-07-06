<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('user-register', 'UserController@register');
Route::post('user-login', 'UserController@login');
Route::get('users', 'UserController@all_users');


Route::get('posts_all', 'UserController@posts_all');
Route::get('post/{id}', 'UserController@post');
Route::post('post', 'UserController@post');

