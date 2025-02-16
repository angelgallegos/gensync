<?php

namespace App\Processors;

use App\Clients\GenpoClient;
use App\DTOs\DTOInterface;
use App\Models\Configuration\ContactStatus;
use App\Services\Models\ContactsService;
use Illuminate\Support\Facades\Log;

/**
 * @template T of DTOInterface
 * @template-implements ProcessorInterface<T>
 */
class ContactsProcessor implements ProcessorInterface
{
    private ContactsService $contactsService;

    private GenpoClient $genpoClient;

    function __construct(
        ContactsService $contactsService,
        GenpoClient $genpoClient
    )
    {
        $this->contactsService = $contactsService;
        $this->genpoClient = $genpoClient;
    }

    /**
     * @param T $dto
     */
    function handle($dto): void
    {
        if ($dto->getStatus()->getKey() == ContactStatus::CREATED_LOCAL["key"]) {
            $contact = $this->genpoClient->createContact($dto);
            Log::debug("Creating contact with id {$contact->getId()} remotely");
            $this->contactsService->updateStatus($contact);
        }

        if ($dto->getStatus()->getKey() == ContactStatus::CREATED_REMOTE["key"]) {
            $contact = $this->genpoClient->attachContactToProfile($dto);
            Log::debug("Attaching contact with id {$contact->getContactId()} to profile with id {$contact->getProfileId()}");
            $this->contactsService->updateStatus($contact);
        }
    }
}
