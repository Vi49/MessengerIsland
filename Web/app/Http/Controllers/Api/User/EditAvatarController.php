<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\EditAvatarRequest;
use Illuminate\Http\Request;

class EditAvatarController extends Controller
{
   public function __invoke(EditAvatarRequest $request)
   {
       if($request->validated()) {

           $user = auth()->user();

           //delete old photo
           if (file_exists(public_path('avatars') . '/' . $user->avatar) && !empty($user->avatar)) {
               unlink(public_path('avatars') . '/' . $user->avatar);
           }

           //set new photo
           $avatarName = time() . $user->user_id . '.' . $request['avatar']->getClientOriginalExtension();
           $request['avatar']->move(public_path('avatars'), $avatarName);

           //add to db
           $user->avatar = $avatarName ?? NULL;
           $user->save();

           return response()->json(['message' => 'Success']);
       }
   }
}
