<?php
namespace App\Http\Services\Messages;

use App\Http\Services\Utils;
use App\Models\Messages;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;


class Service
{
    public static function get_last_message_in_chat($first_user_id, $second_user_id)
    {
        $message = Messages::where(function($query) use ($first_user_id, $second_user_id) {
            $query->where('first_user_id', $first_user_id)
                ->where('second_user_id', $second_user_id);
        })
            ->orWhere(function($query) use ($first_user_id, $second_user_id) {
                $query->where('first_user_id', $second_user_id)
                    ->where('second_user_id', $first_user_id)->where('blocked', false);
            })
            ->orderByDesc('id')
            ->limit(1)
            ->first();

        if(!$message){
            return null;
        }

        if($message->type == 'text'){
            return ['type' => 'text', 'content' => Crypt::decryptString($message->content), 'human_time' => Carbon::parse($message->created_at)->diffForHumans()];
        }
        else if($message->type == 'file'){
            $origin_filename = null;
            $server_filename = null;

            Utils::get_origin_and_server_filename($message->content, $origin_filename, $server_filename);

            return ['type' => 'file', 'origin_filename' => $origin_filename, 'server_filename' => $server_filename, 'human_time' => Carbon::parse($message->created_at)->diffForHumans()];
        }
    }
}
