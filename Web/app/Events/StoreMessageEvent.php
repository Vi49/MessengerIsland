<?php

namespace App\Events;

use App\Http\Resources\Api\Messages\StoreMessageResource;
use App\Models\Messages;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Messages $message;
    private $second_user_id;

    /**
     * Create a new event instance.
     */
    public function __construct(Messages $message, $second_user_id)
    {
        $this->message = $message;
        $this->second_user_id = $second_user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('store_message_'.$this->second_user_id),
        ];
    }

    public function broadcastAs() : string
    {
        return 'store_message';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => new StoreMessageResource($this->message),
        ];
    }
}
