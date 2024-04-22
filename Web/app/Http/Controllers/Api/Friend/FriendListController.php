<?php

namespace App\Http\Controllers\Api\Friend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Friend\FriendListRequest;
use App\Models\Relationships;


class FriendListController extends Controller
{
    public function send_request(FriendListRequest $request)
    {
        if($request->validated()){

            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            Relationships::firstOrCreate([
                "first_user_id" => $first_user_id,
                "second_user_id" => $second_user_id,
                "status" => "requested"
            ]);

            Cache::forget('friendlist_'.auth()->user()->id);

            return response()->json(['message' => 'Success']);
        }
    }

    public function remove_request(FriendListRequest $request)
    {
        if($request->validated()){

            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            $relationship = Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'requested')->first();
            if($relationship) {
                $relationship->delete();

                Cache::forget('friendlist_'.auth()->user()->id);

                return response()->json(['message' => 'Success']);
            }
            else{
                return response()->json(['message' => 'No such friend request']);
            }
        }
    }

    public function decline_request(FriendListRequest $request)
    {
        if($request->validated()){

            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            $relationship = Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'requested')->first();
            if($relationship) {
                $relationship->delete();

                Cache::forget('friendlist_'.auth()->user()->id);

                return response()->json(['message' => 'Success']);
            }
            else{
                return response()->json(['message' => 'No such friend request']);
            }
        }
    }

    public function remove_friend(FriendListRequest $request)
    {
        if($request->validated()){

            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            $firstRelationship = Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'friend')->first();
            $secondRelationship = Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'friend')->first();

            if($firstRelationship && $secondRelationship) {
                $firstRelationship->delete();
                $secondRelationship->delete();

                Cache::forget('friendlist_'.auth()->user()->id);

                return response()->json(['message' => 'Success']);
            }
            else{
                return response()->json(['message' => 'Error finding such friends']);
            }
        }
    }

    public function accept_friend_request(FriendListRequest $request)
    {
        if($request->validated()){

            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            $relation = Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'requested')->first();

            if($relation) {
                $relation->delete();

                Relationships::firstOrCreate([
                    'first_user_id' => $first_user_id,
                    'second_user_id' => $second_user_id,
                    'status' => 'friend'
                ]);

                Relationships::firstOrCreate([
                    'first_user_id' => $second_user_id,
                    'second_user_id' => $first_user_id,
                    'status' => 'friend'
                ]);

                Cache::forget('friendlist_'.auth()->user()->id);

                return response()->json(['message' => 'Success']);
            }
            else{
                return response()->json(['message' => 'No such friend request']);
            }

        }
    }

    public function reject_friend_request(FriendListRequest $request)
    {
        if($request->validated()){

            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            $relation = Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'requested')->first();

            if($relation){
                $relation->delete();

                Cache::forget('friendlist_'.auth()->user()->id);

                return response()->json(['message' => 'Success']);
            }
            else{
                return response()->json(['message' => 'No such friend request']);
            }

        }
    }
}
