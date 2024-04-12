<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Messages\GetAllMessagesRequest;
use App\Http\Requests\Api\Messages\GetFileMessageRequest;
use App\Http\Resources\Api\Messages\GetAllMessagesResource;
use App\Models\Messages;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Http\Services\Utils;

use App\Http\Services\Friends\Status;
use App\Http\Services\Messages\Service;

class GetMessagesController extends Controller
{
    public function get_all_messages(GetAllMessagesRequest $request)
    {
        if($request->validated())
        {
            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];
            $messages = null;

            if(isset($request['page']))
            {
                $messages = Messages::where(function($query) use ($first_user_id, $second_user_id) {
                    $query->where('first_user_id', $first_user_id)
                        ->where('second_user_id', $second_user_id);
                })
                    ->orWhere(function($query) use ($first_user_id, $second_user_id) {
                        $query->where('first_user_id', $second_user_id)
                            ->where('second_user_id', $first_user_id)->where('blocked', false);
                    })
                    ->where('blocked', false)
                    ->orderBy('id')
                    ->paginate(10, ['*'], 'page', $request['page']);
            }
            else{
                $messages = Messages::where(function($query) use ($first_user_id, $second_user_id) {
                    $query->where('first_user_id', $first_user_id)
                        ->where('second_user_id', $second_user_id);
                })
                    ->orWhere(function($query) use ($first_user_id, $second_user_id) {
                        $query->where('first_user_id', $second_user_id)
                            ->where('second_user_id', $first_user_id)->where('blocked', false);
                    })
                    ->orderBy('id')
                    ->get();
            }

            return GetAllMessagesResource::collection($messages)->resolve();
        }
        else{
            return response()->json(['error' => 'Error validating'], 400);
        }
    }

    public function get_file_message(GetFileMessageRequest $request)
    {
        $server_filename = base64_decode($request['server_filename']);
        $origin_filename = base64_decode($request['origin_filename']);

        $filePath = storage_path('app/messages/'.$server_filename);

        // Check if the file exists
        if (file_exists($filePath)) {
            return response()->download($filePath, $origin_filename);
        } else {
            abort(404);
        }
    }
}
