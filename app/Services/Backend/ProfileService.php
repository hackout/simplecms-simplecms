<?php

namespace App\Services\Backend;

use App\Models\Profile;
use SimpleCMS\Framework\Services\SimpleService;

class ProfileService extends SimpleService
{

    public ?string $className = Profile::class;
    
}
