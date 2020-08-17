<?php

namespace App\Events;
use App\User;
use App\Listeners\ChatListener;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $user;
    public function __construct($message,User $user)
    {
       $this->dontBroadcastToCurrentUser();
       $this->message=$message;
       $this->user=$user->name;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }
}
