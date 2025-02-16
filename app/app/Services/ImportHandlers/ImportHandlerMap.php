<?php

namespace App\Services\ImportHandlers;

class ImportHandlerMap
{
    const HANDLERS = array("company" => CompaniesImportHandler::class, "contacts" => ContactsImportsHandler::class);

    public static function getHandler(string $type): string
    {
        return self::HANDLERS[$type];
    }
}
