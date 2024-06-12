<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use App\Services\Private\ManagerLogService;

class SimpleCMSBackendRequests
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Request $event, bool $status): void
    {
        (new ManagerLogService())->makeLog($event, $status);
    }
}
