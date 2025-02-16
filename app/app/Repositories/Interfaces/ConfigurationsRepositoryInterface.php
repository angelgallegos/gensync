<?php

namespace App\Repositories\Interfaces;

use App\Models\Company;
use App\Models\Configuration\Configuration;
use Ramsey\Uuid\Uuid;

interface ConfigurationsRepositoryInterface
{
    public function findByTypeAndKey(string $type, string $key): ?Configuration;
}
