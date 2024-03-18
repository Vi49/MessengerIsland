<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\EditBioRequest;
use Illuminate\Http\Request;

class EditBioController extends Controller
{
   public function __invoke(EditBioRequest $request)
   {
       if($request->validated()) {

           $user = auth()->user();
           $user->bio = $request['bio'];
           $user->save();

           return response()->json(['message' => 'Success']);
       }
   }
}
