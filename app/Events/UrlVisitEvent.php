<?php

namespace App\Events;

use App\Models\Url;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UrlVisitEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Url $url;

    public ?string $ipAddress;

    /**
     *
     * @param Url $url
     * @param string|null $ipAddress
     */
    public function __construct(Url $url, ?string $ipAddress)
    {
        $this->url = $url;
        $this->ipAddress = $ipAddress;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
