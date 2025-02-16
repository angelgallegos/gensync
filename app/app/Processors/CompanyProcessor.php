<?php

namespace App\Processors;

use App\Clients\GenpoClient;
use App\DTOs\DTOInterface;
use App\Services\Models\CompanyService;

/**
 * @template T of DTOInterface
 * @template-implements ProcessorInterface<T>
 */
class CompanyProcessor implements ProcessorInterface
{

    private CompanyService $companyService;

    private GenpoClient $genpoClient;

    function __construct(
        CompanyService $companyService,
        GenpoClient $genpoClient
    )
    {
        $this->companyService = $companyService;
        $this->genpoClient = $genpoClient;
    }

    /**
     * @param T $dto
     */
    public function handle($dto): void
    {
        $company = $this->genpoClient->createCompany($dto);
        $this->companyService->updateStatus($company);
    }
}
