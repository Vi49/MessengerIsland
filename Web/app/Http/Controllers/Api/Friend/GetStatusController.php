<?php

namespace App\Http\Controllers\Api\Friend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Friend\GetStatusRequest;
use App\Models\Relationships;

class GetStatusController extends Controller
{
    public function  __invoke(GetStatusRequest $request)
    {
        if($request->validated()){
            $first_user_id = $request['first_user_id'] ?? auth()->user()->id;
            $second_user_id = $request['second_user_id'];
            $status = '';

            //Check if they are friends
            if(Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'friend')->first() && Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'friend')->first()){
                $status = 'friends';
            }else if(Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'blocked')->first() && Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'blocked')->first()){
                $status = 'blocked both';

            }else if(Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'blocked')->first()){
                $status = 'blocked first';

            }else if(Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'blocked')->first()){
                $status = 'blocked second';
            }
            else{
                $status = 'unknown';
            }

            return response()->json(['status' => $status]);
        }
    }
}
