<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProductNotification
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
     * @param  ProductCreated  $eventF
     * @return void
     */
    public function handle(ProductCreated $event)
    {
        error_log('event triggerd');
        session()->flash('EventStatus', 'New product created!');
    }
}
