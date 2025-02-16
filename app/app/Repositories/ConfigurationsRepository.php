<?php

namespace App\Repositories;

use App\Models\Configuration\Configuration;
use App\Repositories\Interfaces\ConfigurationsRepositoryInterface;

class ConfigurationsRepository implements ConfigurationsRepositoryInterface
{

    public function findByTypeAndKey(string $type, string $key): ?Configuration
    {
        return Configuration::where(["key" => $key, "type" => $type])->first();
    }
}
