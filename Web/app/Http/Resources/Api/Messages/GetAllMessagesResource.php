<?php

namespace App\Http\Resources\Api\Messages;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllMessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "content" => $this->content,
            "type" => $this->type,
            "encryption" => $this->encryption,
            "first_user_id" => $this->first_user_id,
            "second_user_id" => $this->second_user_id,
            "created_at" => $this->created_at,
            "created_at_human" => Carbon::parse($this->created_at)->diffForHumans(),
            "updated_at" => $this->updated_at,
            "updated_at_human" => Carbon::parse($this->updated_at)->diffForHumans(),
        ];
    }
}
