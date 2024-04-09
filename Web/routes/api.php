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
    Route::post('editUsername', 'EditUserNameController');

    //Update current user last seen
    Route::patch('updateLastSeen', 'UpdateLastSeenController');

    //Get limited info about (other or same) user
    Route::post('getInfo', 'GetUserInfo');

});

//Friends (add/block/remove)
//Model Friends status friend/blocked/requested. If remove -> delete row
Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'friend',
    'namespace'=> 'Api\Friend'
], function ($router) {

    Route::post('getStatus', 'GetStatusController');

    Route::post('block', 'BlockUnblockController@block');
    Route::post('unblock', 'BlockUnblockController@unblock');

    Route::post('sendRequest', 'FriendListController@send_request'); //Send (add) request to some user
    Route::post('declineRequest', 'FriendListController@decline_request'); //Decline request to me (first user)
    Route::delete('removeRequest', 'FriendListController@remove_request'); // Remove request I sent to user (second user)
    Route::delete('removeFriend', 'FriendListController@remove_friend'); //Remove user from friends list (works for both)
    Route::post('acceptFriendRequest', 'FriendListController@accept_friend_request'); //Accept Friend request
    Route::post('rejectFriendRequest', 'FriendListController@reject_friend_request'); //Reject Friend request

    Route::get('getFriendList', 'GetFriendListController');
    Route::get('getPendingFriendList', 'GetFriendListController@get_pending_friends');
    Route::get('getBlockedFriendList', 'GetFriendListController@get_blocked_friends');

});


//Messages
Route::group([
    'middleware' => 'auth:api',
    'namespace'=> 'Api\Messages',
    'prefix' => 'message'
], function ($router) {

    //Get messages
    Route::group(['prefix'=>'get'], function (){

        Route::get('all', 'GetMessagesController@get_all_messages'); //Get all messages of chat
    });


    //Sending messages (text, file, photo)
    Route::group(['prefix' => 'send'], function (){
        //TODO: sending photos

        Route::post('sendTextMessage','SendMessageController@send_text_message'); //default: input plain, output in db encrypted with Crypt::encryptString, private: input encrypted, output in db encrypted, the keys are stored only at client-side
        Route::post('sendFileMessage','SendMessageController@send_file_message');
    });
});


//Search
Route::group([
    'middleware' => 'jwt.auth',
    'namespace'=> 'Api\Search',
    'prefix' => 'search'
], function ($router) {

    Route::post('/','SearchController');
});

