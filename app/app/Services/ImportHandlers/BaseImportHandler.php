<?php

namespace App\Services\ImportHandlers;

abstract class BaseImportHandler implements ImportHandler
{

    public function import(string $fullPath): void
    {
        $rawData = $this->read($fullPath);
        $data = $this->convert($rawData);
        $this->process($data);
    }
}
