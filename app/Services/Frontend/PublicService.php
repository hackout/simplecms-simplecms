<?php

namespace App\Services\Frontend;

use Illuminate\Support\Collection;
use SimpleCMS\Framework\Facades\SystemConfig;

class PublicService
{

    public function init(): Collection
    {
        $result = SystemConfig::getConfigs();
        return $result->pluck('value', 'code');
    }
}
