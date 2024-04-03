<?php

namespace App\Http\Controllers\Api\Friend;

use App\Http\Controllers\Controller;
use App\Models\BlockRelationships;
use App\Models\Relationships;
use App\Http\Requests\Api\Friend\BlockUnblockRequest;

class BlockUnblockController extends Controller
{
    public function block(BlockUnblockRequest $request)
    {
        if($request->validated()){

            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            BlockRelationships::firstOrCreate([
                'first_user_id' => $first_user_id,
                'second_user_id' => $second_user_id
            ]);

            return response()->json(['message' => 'Blocked']);
        }
    }

    public function unblock(BlockUnblockRequest $request)
    {
        if($request->validated()){

            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            $relationship = BlockRelationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->first();
            if($relationship) {
                $relationship->delete();

                return response()->json(['message' => 'Unblocked']);
            }else{
                return response()->json(['message' => 'Block relationship not found']);
            }
        }
    }
}
