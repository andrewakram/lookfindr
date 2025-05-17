<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskAssignmentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //ToDo
    }

    /**
     * Handle the event.
     */
    public function handle(TaskAssigned $event): void
    {
        //ToDo
    }
}
