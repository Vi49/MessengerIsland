<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\EditFirstNameRequest;
use Illuminate\Http\Request;

class EditFirstNameController extends Controller
{
   public function __invoke(EditFirstNameRequest $request)
   {
       $request->validated();

       $user = auth()->user();
       $user->first_name = $request['first_name'];
       $user->save();
   }
}
