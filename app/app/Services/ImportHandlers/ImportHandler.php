<?php

namespace App\Services\ImportHandlers;

interface ImportHandler
{
    function import(string $fullPath): void;

    function read(string $fullPath): array;

    function process(array $data): array;

    function convert(array $rawData): array;
}
