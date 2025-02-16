<?php

namespace App\Services\ImportHandlers;

use App\DTOs\CompanyDTO;
use App\Services\Models\CompanyService;
use App\Services\Readers\CsvReader;
use App\Utils\Converter;

class CompaniesImportHandler extends BaseImportHandler
{
    private CsvReader $csvReader;

    private CompanyService $companyService;

    function __construct(
        CsvReader $csvReader,
        CompanyService $companyService
    )
    {
        $this->csvReader = $csvReader;
        $this->companyService = $companyService;
    }

    public function read(string $fullPath): array
    {
        return $this->csvReader->read($fullPath);
    }


    /**
     * @throws \Exception
     */
    function process(array $data): array
    {
        foreach ($data as $value) {
            $this->companyService->create($value);
        }

        return $data;
    }

    function convert(array $rawData): array
    {
        $arrayObjects = array();
        foreach ($rawData as $data) {
            $arrayObjects[] = Converter::toObject($data, new CompanyDTO());
        }

        return $arrayObjects;
    }
}
