<?php

namespace App\Repositories\Interfaces;

use App\DTOs\CompanyDTO;
use App\Models\Company;
use App\Models\Configuration\Configuration;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    public function all(): Collection;
    public function store(?string $id, CompanyDTO $data, Configuration $configuration);
    public function find(string $id): ?Company;
}
