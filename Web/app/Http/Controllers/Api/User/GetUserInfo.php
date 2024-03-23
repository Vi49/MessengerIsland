<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\GetUserInfoRequest;
use App\Http\Resources\Api\User\GetUserInfoResource;
use App\Models\User;

class GetUserInfo extends Controller
{
    public function __invoke(GetUserInfoRequest $request)
    {
        if($request->validated()) {
            $user_id = $request['user_id'] ?? auth()->user()->user_id;

            $result = User::where('user_id', $user_id)->first();

            if($result){
                return new GetUserInfoResource($result);
            }
            else{
                return response()->json(['message' => 'Fail']);
            }
        }
    }
}
