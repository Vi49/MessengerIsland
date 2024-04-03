<?php

namespace App\Http\Resources\Api\Friend;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetPendingFriendListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $id = $this->first_user_id;
        $friendUser = User::find($id);

        return [
            'id' => $id,
            'first_name' => $friendUser->first_name,
            'last_name' => $friendUser->last_name,
            'user_id' => $friendUser->user_id,
            'username' => $friendUser->username,
            'role' => $friendUser->role,
            'avatar' => $friendUser->avatar,
            'last_seen' => $friendUser->last_seen,
            'last_seen_human_ago' => Carbon::parse($friendUser->last_seen)->diffForHumans(),
        ];
    }
}
