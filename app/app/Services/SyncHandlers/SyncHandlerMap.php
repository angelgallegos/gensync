<?php

namespace App\Services\SyncHandlers;

class SyncHandlerMap
{
    const HANDLERS = array("company" => CompaniesSyncHandler::class, "contacts" => ContactsSyncHandler::class, "attach" => ContactsAttachSyncHandler::class);

    public static function getHandler(string $type): string
    {
        return self::HANDLERS[$type];
    }
}
