<?php

namespace App\DTOs;

use App\Models\Company;

class CompanyDTO implements DTOInterface, RequestDTOInterface
{
    private string $id;
    private string $name;

    private ?string $response = null;

    private ?string $errorMessage = null;

    private ?ConfigurationDTO $status = null;

    private ?string $profileId = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): void
    {
        $this->response = $response;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    public function getStatus(): ?ConfigurationDTO
    {
        return $this->status;
    }

    public function setStatus(?ConfigurationDTO $status): void
    {
        $this->status = $status;
    }

    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    public function setProfileId(?string $profileId): void
    {
        $this->profileId = $profileId;
    }

    public function toArray(): array
    {
        return array(
            "id" => $this->getId(),
            "name" => $this->getName(),
            "error_message" => $this->getErrorMessage(),
            "response" => $this->getResponse(),
            "profile_id" => $this->getProfileId()
        );
    }

    public static function fromModel(Company $company): CompanyDTO
    {
        $companyDTO = new self();
        $companyDTO->setId($company->id);
        $companyDTO->setName($company->name);
        $companyDTO->setErrorMessage($company->error_message);
        $companyDTO->setResponse($company->response);
        $companyDTO->setStatus(ConfigurationDTO::fromModel($company->status));
        $companyDTO->setProfileId($company->profile_id);

        return $companyDTO;
    }

    function toRequestJson(): string
    {
        return json_encode(
            array("name" => $this->getName())
        );
    }
}
