<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


//Auth procedures(e.g. login, logout, register, after register, me, token refresh)
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::post('afterreg', 'AuthController@afterreg');

});

//User manipulations
Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'user',
    'namespace'=> 'Api\User'
], function ($router) {

    //Edit current user data apis
    Route::post('editBio', 'EditBioController');
    Route::post('editFirstName', 'EditFirstNameController');
    Route::post('editLastName', 'EditLastNameController');
    Route::post('editAvatar', 'EditAvatarController');


    //Friends (add/block/remove)
    //Model Friends status friend/blocked/requested. If remove -> delete row

});

