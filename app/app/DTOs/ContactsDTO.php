<?php

namespace App\DTOs;

use App\Models\Contacts;
use DateTime;
use DateTimeInterface;

class ContactsDTO implements DTOInterface, RequestDTOInterface
{
    private string $id;
    private string $name;
    private ?string $phone = null;
    private string $email;
    private ?DateTime $dateOfBirth = null;
    private ?string $companyId = null;
    private ?string $response = null;

    private ?string $errorMessage = null;

    private ?ConfigurationDTO $status = null;

    private ?string $channelId = null;
    private ?string $contactId = null;
    private ?string $profileId = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getDateOfBirth(): ?DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?string $dateOfBirth): void
    {
        if (!is_null($dateOfBirth)) {
            $format = DateTimeInterface::RFC3339;

            $this->dateOfBirth = DateTime::createFromFormat($format, $dateOfBirth);
        }
    }

    public function setDateOfBirthFromModel(?string $dateOfBirth): void
    {
        if (!is_null($dateOfBirth)) {
            $this->dateOfBirth = DateTime::createFromFormat('Y-m-d H:i:s', $dateOfBirth);
        }
    }

    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    public function setCompanyId(?string $companyId): void
    {
        $this->companyId = $companyId;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): void
    {
        $this->response = $response;
    }

    public function getStatus(): ?ConfigurationDTO
    {
        return $this->status;
    }

    public function setStatus(?ConfigurationDTO $status): void
    {
        $this->status = $status;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function setChannelId(?string $channelId): void
    {
        $this->channelId = $channelId;
    }

    public function getContactId(): ?string
    {
        return $this->contactId;
    }

    public function setContactId(?string $contactId): void
    {
        $this->contactId = $contactId;
    }

    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    public function setProfileId(?string $profileId): void
    {
        $this->profileId = $profileId;
    }

    public static function fromModel(Contacts $contacts): ContactsDTO
    {
        $contactsDTO = new self();
        $contactsDTO->setId($contacts->id);
        $contactsDTO->setName($contacts->name);
        $contactsDTO->setPhone($contacts->phone);
        $contactsDTO->setEmail($contacts->email);
        $contactsDTO->setDateOfBirthFromModel($contacts->date_of_birth);
        $contactsDTO->setCompanyId($contacts->company->id);
        $contactsDTO->setProfileId($contacts->company->profile_id);
        $contactsDTO->setErrorMessage($contacts->error_message);

        if (!empty($contacts->response))
            $contactsDTO->setResponse(json_encode($contacts->response));

        $contactsDTO->setStatus(ConfigurationDTO::fromModel($contacts->status));
        $contactsDTO->setContactId($contacts->contact_id);

        return $contactsDTO;
    }

    function toArray(): array
    {
        return array(
            "id" => $this->getId(),
            "name" => $this->getName(),
            "phone" => $this->getPhone(),
            "email" => $this->getEmail(),
            "date_of_birth" => $this->getDateOfBirth(),
            "company_id" => $this->getCompanyId(),
            "error_message" => $this->getErrorMessage(),
            "response" => $this->getResponse(),
            "status_id" => !is_null($this->getStatus())?$this->getStatus()->getId():null,
            "contact_id" => $this->getContactId()
        );
    }

    function toRequestJson(): string
    {
        return json_encode(
            array(
                "identifier" => (is_null($this->getEmail()) && !filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL))?
                    $this->getPhone():
                    $this->getEmail(),
                "name" => $this->getName(),
                "channel_id" => $this->getChannelId()
            )
        );
    }
}
