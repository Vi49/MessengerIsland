<?php
namespace App\Http\Services\Friends;


use App\Models\BlockRelationsips;
use App\Models\Relationships;

class Status
{
    public static function getFriendStatus($first_user_id, $second_user_id, $request_role) : string{
        $status = '';

        if($request_role == 'user') {
            if (Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'friend')->first() && Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'friend')->first()) {
                $status = 'friends';

            } else if (Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'requested')->first()) {
                $status = 'requested first';

            } else if (Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'requested')->first()) {
                $status = 'requested second';

            } else {
                $status = 'unknown';
            }
        }
        else if($request_role == 'admin')
        {
            if (Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'friend')->first() && Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'friend')->first()) {
                $status = 'friends';

            }else if (Relationships::where('first_user_id', $second_user_id)->where('second_user_id', $first_user_id)->where('status', 'requested')->first()) {
                $status = 'requested first';

            } else if (Relationships::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->where('status', 'requested')->first()) {
                $status = 'requested second';

            } else {
                $status = 'unknown';
            }
        }

        return $status;
    }

    public static function isBlocking($first_user_id, $second_user_id) : bool{
        if (BlockRelationsips::where('first_user_id', $first_user_id)->where('second_user_id', $second_user_id)->first()) {
            return true;
        }

        return false;
    }
}

