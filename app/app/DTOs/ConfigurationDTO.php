<?php

namespace App\DTOs;

use App\Models\Configuration\Configuration;

class ConfigurationDTO implements DTOInterface
{
    private ?string $id = null;
    private string $type;

    private string $key;

    private string $value;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public static function fromModel(Configuration $configuration): ConfigurationDTO
    {
        $configurationDTO = new ConfigurationDTO();
        $configurationDTO->setId($configuration->id);
        $configurationDTO->setKey($configuration->key);
        $configurationDTO->setType($configuration->type);
        $configurationDTO->setValue($configuration->value);

        return $configurationDTO;
    }
    function toArray(): array
    {
        return array(
            "id" => $this->getId(),
            "type" => $this->getType(),
            "key" => $this->getKey(),
            "value" => $this->getValue()
        );
    }
}
