<?php

namespace App\Services\Private;

use App\Models\Account;
use SimpleCMS\Framework\Services\SimpleService;
use App\Enums\Account as AccountEnum;

class AccountService extends SimpleService
{
    public ?string $className = Account::class;
    
}