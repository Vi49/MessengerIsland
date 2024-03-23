<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class GetUserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user_id" => $this->user_id,
            "username" => $this->username,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "role" => $this->role,
            "avatar" => $this->avatar,
            "bio" => $this->bio,
            "last_seen" => $this->last_seen,
            'last_seen_human_ago' => Carbon::parse($this->last_seen)->diffForHumans(),
        ];
    }
}
