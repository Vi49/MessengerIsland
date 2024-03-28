<?php

namespace App\Http\Controllers\Api\Friend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Friend\GetStatusRequest;
use App\Http\Services\Friends\Status;
use App\Models\Relationships;

class GetStatusController extends Controller
{
    public function  __invoke(GetStatusRequest $request)
    {
        if($request->validated()){
            $first_user_id = $request['first_user_id'] ?? auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            return response()->json(['status' => Status::getFriendStatus($first_user_id, $second_user_id, 'user'), 'is_blocking' => Status::isBlocking($first_user_id, $second_user_id)]);
        }
    }
}
