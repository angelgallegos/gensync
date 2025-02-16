<?php

namespace App\Services\ImportHandlers;

use App\DTOs\ContactsDTO;
use App\Services\Models\ContactsService;
use App\Services\Readers\CsvReader;
use App\Utils\Converter;
use League\Csv\Exception;
use League\Csv\UnavailableStream;

class ContactsImportsHandler extends BaseImportHandler
{
    private CsvReader $csvReader;

    private ContactsService $contactsService;

    function __construct(
        CsvReader $csvReader,
        ContactsService $contactsService
    )
    {
        $this->csvReader = $csvReader;
        $this->contactsService = $contactsService;
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    function read(string $fullPath): array
    {
        return $this->csvReader->read($fullPath);
    }

    /**
     * @throws \Exception
     */
    function process(array $data): array
    {
        foreach ($data as $value) {
            $this->contactsService->create($value);
        }

        return $data;
    }

    function convert(array $rawData): array
    {
        $arrayObjects = array();
        foreach ($rawData as $data) {
            $arrayObjects[] = Converter::toObject($data, new ContactsDTO());
        }

        return $arrayObjects;
    }
}
