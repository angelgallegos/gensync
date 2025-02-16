<?php

namespace App\Services\Models;

use App\DTOs\CompanyDTO;
use App\Models\Company;
use App\Models\Configuration\CompanyStatus;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Exception;

class CompanyService
{
    private CompanyRepositoryInterface $companyRepository;

    private ConfigurationService $configurationService;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        ConfigurationService $configurationService
    )
    {
        $this->companyRepository = $companyRepository;
        $this->configurationService = $configurationService;
    }

    public function find(string $id): ?Company
    {
        return $this->companyRepository->find($id);
    }

    /**
     * @throws Exception
     */
    public function create(CompanyDTO $companyDTO): Company
    {
        $company = $this->companyRepository->find($companyDTO->getId());
        $status = $this->configurationService->findByTypeAndKey(CompanyStatus::CREATED_LOCAL["type"], CompanyStatus::CREATED_LOCAL["key"]);
        if (is_null($status)) {
            throw new Exception("Status not found");
        }
        if (is_null($company)) {
            return $this->companyRepository->store(null, $companyDTO, $status);
        }

        return $this->companyRepository->store($companyDTO->getId(), $companyDTO, $status);
    }

    public function markAsSent(CompanyDTO $companyDTO): Company
    {
        $status = $this->configurationService->findByTypeAndKey(CompanyStatus::REMOTE_CREATION_IN_PROGRESS["type"], CompanyStatus::REMOTE_CREATION_IN_PROGRESS["key"]);
        return $this->companyRepository->updateStatus($companyDTO, $status);
    }

    public function markAsFailedToSend(CompanyDTO $companyDTO): Company
    {
        $status = $this->configurationService->findByTypeAndKey(CompanyStatus::FAIL_CREATE_LOCAL["type"], CompanyStatus::FAIL_CREATE_LOCAL["key"]);
        return $this->companyRepository->updateStatus($companyDTO, $status);
    }

    public function listToSync(): array
    {
        $status = $this->configurationService->findByTypeAndKey(CompanyStatus::CREATED_LOCAL["type"], CompanyStatus::CREATED_LOCAL["key"]);
        $listToSync = array();
        foreach ($this->companyRepository->listByStatus($status) as $company) {
            $listToSync[] = CompanyDTO::fromModel($company);
        }

        return $listToSync;
    }
    public function updateStatus(CompanyDTO $companyDTO): Company
    {
        $status = $this->configurationService->findByTypeAndKey($companyDTO->getStatus()->getType(), $companyDTO->getStatus()->getKey());
        return $this->companyRepository->store($companyDTO->getId(), $companyDTO, $status);
    }
}
