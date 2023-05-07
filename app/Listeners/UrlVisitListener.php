<?php

namespace App\Listeners;

use App\Events\UrlVisitEvent;
use App\Models\Url;
use App\Models\UrlVisit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UrlVisitListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UrlVisitEvent  $event
     * @return void
     */
    public function handle(UrlVisitEvent $event)
    {
        $this->recordVisit($event->ipAddress, $event->url);
    }


    /**
     * @param string|null $ip
     * @param Url $url
     * @return void
     */
    private function recordVisit(?string $ip, Url $url): void
    {
        $visit = new UrlVisit();
        $visit->url_id = $url->id;
        $visit->visited_at = now();
        $visit->ip_address = $ip;
        $visit->save();
    }
}
