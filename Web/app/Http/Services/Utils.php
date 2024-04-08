<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class Utils
{
    public static function generate_user_id($email) : string{
        return substr(sha1($email.(string)time()), 0, 15);
    }

    public static function get_chat_messages_folder($first_user_id, $second_user_id)
    {
        $first_user_email = User::find($first_user_id)->email;
        $second_user_email = User::find($second_user_id)->email;

        return substr(sha1($first_user_email.$second_user_email), 0, 15);
    }
}

