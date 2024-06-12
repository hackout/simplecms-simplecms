<?php

namespace App\Services\Frontend;

use App\Models\Manager;
use App\Models\User;
use SimpleCMS\Framework\Services\SimpleService;

class ManagerService extends SimpleService
{

    public ?string $className = Manager::class;
    
}
