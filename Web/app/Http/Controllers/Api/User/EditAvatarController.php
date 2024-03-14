<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\EditAvatarRequest;
use Illuminate\Http\Request;

class EditAvatarController extends Controller
{
   public function __invoke(EditAvatarRequest $request)
   {
       $request->validated();

       $user = auth()->user();

       //set new photo
       $avatarName = time() . $user->user_id . '.' . $request['avatar']->getClientOriginalExtension();
       $request['avatar']->move(public_path('avatars'), $avatarName);

       //add to db
       $user->avatar = $avatarName;
       $user->save();

   }
}
