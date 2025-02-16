<?php

namespace App\Services\Readers;

use Illuminate\Support\LazyCollection;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class CsvReader
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function read(string $fullPath): array
    {
        $data = Reader::createFromPath($fullPath);
        $data->setHeaderOffset(0);

        return LazyCollection::make(static fn () => yield from $data->getRecords())
            ->toArray();
    }
}
