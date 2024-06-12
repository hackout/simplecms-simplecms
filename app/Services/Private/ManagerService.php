<?php

namespace App\Services\Private;

use App\Models\Manager;
use SimpleCMS\Framework\Services\SimpleService;

class ManagerService extends SimpleService
{
    public ?string $className = Manager::class;

}
