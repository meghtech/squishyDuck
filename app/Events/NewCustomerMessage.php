<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Customer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Log;


class NewCustomerMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Customer $user, Message $message)
    {
        log::info("Customer");
        $this->user = $user;
        $this->message = $message;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('chat');
    }

    public function broadcastAs()
    {
        return 'NewMessage';
    }
}
