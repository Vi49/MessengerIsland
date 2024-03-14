<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\EditLastNameRequest;
use Illuminate\Http\Request;

class EditLastNameController extends Controller
{
   public function __invoke(EditLastNameRequest $request)
   {
       $request->validated();

       $user = auth()->user();
       $user->last_name = $request['last_name'];
       $user->save();
   }
}
