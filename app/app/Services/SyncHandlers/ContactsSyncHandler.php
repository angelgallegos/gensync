<?php

namespace App\Services\SyncHandlers;

use App\Jobs\ProcessContacts;
use App\Services\Models\ContactsService;
use Exception;
use Illuminate\Support\Facades\Log;

class ContactsSyncHandler implements SyncHandlerInterface
{
    private ContactsService $contactsService;
    public function __construct(ContactsService $contactsService)
    {
        $this->contactsService = $contactsService;
    }

    function sync(): void
    {
        $contacts = $this->contactsService->listToSync();
        Log::debug("Total size of contacts to sync: ".sizeof($contacts));
        foreach ($contacts as $contact) {
            try {
                $this->contactsService->markAsSent($contact);
                ProcessContacts::dispatch($contact)->afterCommit();
            } catch (Exception $e) {
                Log::error("Exception while creating contact: ".$e->getMessage());
                $this->contactsService->markAsFailedToSend($contact);
            }
        }
    }
}
