<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

class UpdateLastSeenController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $user->last_seen = date('Y-m-d H:i:s', time());
        $user->save();

        return response()->json(['message' => 'Success']);

    }
}
