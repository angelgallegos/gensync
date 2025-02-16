<?php

namespace App\Processors;

use App\DTOs\DTOInterface;

/**
 * @template T of DTOInterface
 */
interface ProcessorInterface
{
    /**
     * @param T $dto
     */
    function handle($dto): void;
}
