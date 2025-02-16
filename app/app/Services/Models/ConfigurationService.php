<?php

namespace App\Services\Models;

use App\Models\Configuration\Configuration;
use App\Repositories\Interfaces\ConfigurationsRepositoryInterface;

class ConfigurationService
{
    private ConfigurationsRepositoryInterface $configurationsRepository;
    public function __construct(ConfigurationsRepositoryInterface $configurationsRepository)
    {
        $this->configurationsRepository = $configurationsRepository;
    }

    public function findByTypeAndKey(string $type, string $key): ?Configuration
    {
        return $this->configurationsRepository->findByTypeAndKey($type, $key);
    }
}
