<?php

namespace App\Http\Controllers\Api\Friend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Friend\GetStatusRequest;
use App\Http\Resources\Api\Friend\GetFriendListResource;
use App\Http\Resources\Api\Friend\GetPendingFriendListResource;
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

    public function get_pending_friends()
    {
        $first_user_id = auth()->user()->id;

        $friends = User::find($first_user_id)->pending_friends;
        //dd($friends);

        return GetPendingFriendListResource::collection($friends);
    }

    public function get_blocked_friends()
    {
        $first_user_id = auth()->user()->id;

        $friends = User::find($first_user_id)->blocked_friends;

        return GetFriendListResource::collection($friends);
    }
}
