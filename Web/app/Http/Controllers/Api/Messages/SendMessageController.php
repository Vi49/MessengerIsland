<?php

namespace App\Http\Controllers\Api\Messages;

use App\Events\StoreMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Messages\SendFileMessageRequest;
use App\Http\Requests\Api\Messages\SendTextMessageRequest;
use App\Models\Messages;
use Hamcrest\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Services\Utils;

use App\Http\Services\Friends\Status;

class SendMessageController extends Controller
{
    public function send_text_message(SendTextMessageRequest $request)
    {
        if($request->validated())
        {
            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            if(Status::getFriendStatus($first_user_id, $second_user_id, 'user') == 'friends') {

                if (empty($request['encryption']) || $request['encryption'] == 'default') {
                    $encryptedMessage = Crypt::encryptString($request['content']);

                    $isBlocking = Status::isBlocking($first_user_id, $second_user_id);

                    $message = Messages::create([
                        'content' => $encryptedMessage,
                        'type' => 'text',
                        'encryption' => 'default',
                        'blocked' => $isBlocking,
                        'first_user_id' => $first_user_id,
                        'second_user_id' => $second_user_id,
                    ]);

                    broadcast(new StoreMessageEvent($message, $second_user_id))->toOthers();

                }
            }
            else{
                return response()->json(['error' => 'You are not a friend'], 400);
            }
        }
        else{
            return response()->json(['error' => 'Error validating'], 400);
        }
    }

    public function send_file_message(SendFileMessageRequest $request)
    {
        if($request->validated())
        {
            $first_user_id = auth()->user()->id;
            $second_user_id = $request['second_user_id'];

            if(Status::getFriendStatus($first_user_id, $second_user_id, 'user') == 'friends') {

                $file = $request->file('file');

                $directory = 'messages/'.Utils::get_chat_messages_folder($first_user_id, $second_user_id);
                Storage::makeDirectory($directory);

                $fileName = md5((string)time().$file->getClientOriginalName());
                $file->storeAs($directory, $fileName);

                $isBlocking = Status::isBlocking($first_user_id, $second_user_id);

                $content = base64_encode($file->getClientOriginalName()).'|'.base64_encode(Utils::get_chat_messages_folder($first_user_id, $second_user_id).'/'.$fileName);
                $message = Messages::create([
                    'content' => $content,
                    'type' => 'file',
                    'encryption' => 'none',
                    'blocked' => $isBlocking,
                    'first_user_id' => $first_user_id,
                    'second_user_id' => $second_user_id,
                ]);

                broadcast(new StoreMessageEvent($message, $second_user_id))->toOthers();

                return response()->json(['content' => $content]);
            }
            else{
                return response()->json(['error' => 'You are not a friend'], 400);
            }
        }
        else{
            return response()->json(['error' => 'Error validating'], 400);
        }
    }
}
