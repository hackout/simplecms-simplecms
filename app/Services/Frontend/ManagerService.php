<?php

namespace App\Services\Frontend;

use App\Models\Manager;
use SimpleCMS\Framework\Services\SimpleService;

class ManagerService extends SimpleService
{

    public string $className = Manager::class;
    
}
