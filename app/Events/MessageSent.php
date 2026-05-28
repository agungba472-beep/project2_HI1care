<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function broadcastOn()
    {
        // Mengurutkan ID (Misal Nakes=2, Pasien=5) agar channelnya selalu "chat.2.5"
        // Tidak peduli siapa yang mengirim pesan duluan.
        $userIds = [$this->chat->sender_id, $this->chat->receiver_id];
        sort($userIds); 

        return new PrivateChannel('chat.' . $userIds[0] . '.' . $userIds[1]);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}