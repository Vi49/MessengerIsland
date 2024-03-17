<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Hash;

class Utils
{
    public static function generate_user_id($email) : string{
        return substr(sha1($email.(string)time()), 0, 15);
    }
}

