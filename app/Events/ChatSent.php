<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Chat $chat;

    /**
     * Create a new event instance.
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $first = min($this->chat->recipient_id, $this->chat->sender_id);
        $second = max($this->chat->recipient_id, $this->chat->sender_id);
        return [
            new PrivateChannel('chat.' . $first . "." . $second),
        ];
    }
}
