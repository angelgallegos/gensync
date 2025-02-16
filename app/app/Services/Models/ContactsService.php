<?php

namespace App\Services\Models;

use App\DTOs\ConfigurationDTO;
use App\DTOs\ContactsDTO;
use App\Models\Configuration\CompanyStatus;
use App\Models\Configuration\ContactStatus;
use App\Models\Contacts;
use App\Repositories\Interfaces\ContactsRepositoryInterface;
use Exception;

class ContactsService
{
    private ContactsRepositoryInterface $contactsRepository;

    private CompanyService $companyService;

    private ConfigurationService $configurationService;
    public function __construct(
        ContactsRepositoryInterface $contactsRepository,
        CompanyService $companyService,
        ConfigurationService $configurationService
    )
    {
        $this->contactsRepository = $contactsRepository;
        $this->companyService = $companyService;
        $this->configurationService = $configurationService;
    }

    /**
     * @throws Exception
     */
    public function create(ContactsDTO $contactsDTO): Contacts
    {
        $contacts = $this->contactsRepository->find($contactsDTO->getId());

        $status = $this->configurationService->findByTypeAndKey(ContactStatus::CREATED_LOCAL["type"], ContactStatus::CREATED_LOCAL["key"]);
        if (is_null($status)) {
            throw new Exception("Status not found");
        }
        $company = $this->companyService->find($contactsDTO->getCompanyId());

        if (is_null($company)) {
            $status = $this->configurationService->findByTypeAndKey(ContactStatus::FAIL_CREATE_LOCAL["type"], ContactStatus::FAIL_CREATE_LOCAL["key"]);
            $contactsDTO->setErrorMessage("Company not found");
        }

        if (is_null($contacts)) {
            return $this->contactsRepository->store(null, $contactsDTO, $status, $company);
        }

        return $this->contactsRepository->store($contactsDTO->getId(), $contactsDTO, $status, $company);
    }

    public function markAsSent(ContactsDTO $contactsDTO): Contacts
    {
        $status = $this->configurationService->findByTypeAndKey(ContactStatus::REMOTE_CREATION_IN_PROGRESS["type"], ContactStatus::REMOTE_CREATION_IN_PROGRESS["key"]);
        return $this->contactsRepository->updateStatus($contactsDTO, $status);
    }

    public function markAsSentToAttach(ContactsDTO $contactsDTO): Contacts
    {
        $status = $this->configurationService->findByTypeAndKey(ContactStatus::ATTACHING_IN_PROGRESS["type"], ContactStatus::ATTACHING_IN_PROGRESS["key"]);
        return $this->contactsRepository->updateStatus($contactsDTO, $status);
    }

    public function markAsFailedToSend(ContactsDTO $companyDTO): Contacts
    {
        $status = $this->configurationService->findByTypeAndKey(ContactStatus::FAIL_TO_SEND_TO_CREATE["type"], ContactStatus::FAIL_TO_SEND_TO_CREATE["key"]);
        return $this->contactsRepository->updateStatus($companyDTO, $status);
    }

    public function markAsFailedToSendToAttach(ContactsDTO $companyDTO): Contacts
    {
        $status = $this->configurationService->findByTypeAndKey(ContactStatus::FAIL_TO_SEND_TO_ATTACH["type"], ContactStatus::FAIL_TO_SEND_TO_ATTACH["key"]);
        return $this->contactsRepository->updateStatus($companyDTO, $status);
    }

    public function listToSync(): array
    {
        $status = $this->configurationService->findByTypeAndKey(ContactStatus::CREATED_LOCAL["type"], ContactStatus::CREATED_LOCAL["key"]);
        $companyStatus = $this->configurationService->findByTypeAndKey(CompanyStatus::CREATED_REMOTE["type"], ContactStatus::CREATED_REMOTE["key"]);
        $listToSync = array();
        foreach ($this->contactsRepository->listByStatusAndCompanyStatus($status, $companyStatus) as $contacts) {
            $contact = ContactsDTO::fromModel($contacts);
            //Should the channel id be one single, per env, value or change per request, and if so where should it come from? The csv file?
            $contact->setChannelId(config('client.contact.create.channel_id'));
            $listToSync[] = $contact;
        }

        return $listToSync;
    }

    public function listToAttach(): array
    {
        $status = $this->configurationService->findByTypeAndKey(ContactStatus::CREATED_REMOTE["type"], ContactStatus::CREATED_REMOTE["key"]);
        $listToSync = array();
        foreach ($this->contactsRepository->listByStatus($status) as $contacts) {
            $contact = ContactsDTO::fromModel($contacts);
            $listToSync[] = $contact;
        }

        return $listToSync;
    }

    public function updateStatus(ContactsDTO $contactsDTO): Contacts
    {
        $status = $this->configurationService->findByTypeAndKey($contactsDTO->getStatus()->getType(), $contactsDTO->getStatus()->getKey());
        $company = $this->companyService->find($contactsDTO->getCompanyId());
        $contactsDTO->setStatus(ConfigurationDTO::fromModel($status));
        return $this->contactsRepository->store($contactsDTO->getId(), $contactsDTO, $status, $company);
    }
}
