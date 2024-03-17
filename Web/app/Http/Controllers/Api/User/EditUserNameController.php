<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\EditUserNameRequest;
use Illuminate\Http\Request;

class EditUserNameController extends Controller
{
   public function __invoke(EditUserNameRequest $request)
   {
       $request->validated();

       $user = auth()->user();
       $user->username = $request['username'];
       $user->save();

       return response()->json(['message'=>'Success']);
   }
}
