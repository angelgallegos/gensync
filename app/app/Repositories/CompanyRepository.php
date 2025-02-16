<?php

namespace App\Repositories;

use App\DTOs\CompanyDTO;
use App\Models\Company;
use App\Models\Configuration\Configuration;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{

    public function all(): Collection
    {
        return Company::all();
    }

    public function store(?string $id, CompanyDTO $data, Configuration $configuration): Company
    {
        $company = Company::find($id);
        if(is_null($company)) {
            $company = new Company();
        }
        $company->fill($data->toArray());
        $company->status()->associate($configuration);
        $company->save();

        return $company;
    }

    public function find(string $id): ?Company
    {
        return Company::find($id);
    }

    public function updateStatus(CompanyDTO $companyDTO, Configuration $status): Company
    {
        $company = $this->find($companyDTO->getId());
        $company->status()->associate($status);
        $company->save();

        return $company;
    }

    public function listByStatus(Configuration $status)
    {
        return Company::where("status_id", $status->id)->limit(40)->orderBy("created_at", "desc")->get();
    }
}
