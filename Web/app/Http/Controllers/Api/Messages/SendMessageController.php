<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Messages\SendMessageRequest;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

use App\Http\Services\Friends\Status;

class SendMessageController extends Controller
{
    public function send_text_message(SendMessageRequest $request)
    {
        if($request->validated())
        {
            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            if(Status::getFriendStatus($first_user_id, $second_user_id, 'user') == 'friends') {

                if (empty($request['encryption']) || $request['encryption'] == 'default') {
                    $encryptedMessage = Crypt::encryptString($request['content']);

                    $isBlocking = Status::isBlocking($first_user_id, $second_user_id);

                    Messages::create([
                        'content' => $encryptedMessage,
                        'type' => 'text',
                        'encryption' => 'default',
                        'blocked' => $isBlocking,
                        'first_user_id' => $first_user_id,
                        'second_user_id' => $second_user_id,
                    ]);

                }
            }
        }
    }
}
