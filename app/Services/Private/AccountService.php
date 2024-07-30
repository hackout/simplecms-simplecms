<?php

namespace App\Services\Private;

use App\Models\Account;
use SimpleCMS\Framework\Services\SimpleService;

class AccountService extends SimpleService
{
    public string $className = Account::class;
    
}