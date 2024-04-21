<?php

namespace App\Http\Resources\Api\Messages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class StoreMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $content = null;
        if($this->type == 'text'){
            if($this->encryption == 'default'){
                $content = Crypt::decryptString($this->content);
            }
        }
        else if($this->type == 'file'){
            $content = $this->content;
        }


        return [
            'content' => $content,
            'type' => $this->type,
            'encryption' => $this->encryption,
            'blocked' => $this->blocked,
            'first_user_id' => $this->first_user_id,
            'second_user_id' => $this->second_user_id,
        ];
    }
}
