<?php

namespace App\Http\Controllers\Api\Friend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Friend\GetStatusRequest;
use App\Http\Resources\Api\Friend\GetFriendListResource;
use App\Http\Services\Friends\Status;
use App\Models\Relationships;
use App\Models\User;

class GetFriendListController extends Controller
{
    public function  __invoke()
    {
        $first_user_id = auth()->user()->id;

        $friends = User::find($first_user_id)->friends;

        return GetFriendListResource::collection($friends);
    }
}
