<?php

namespace App\Models\Configuration;

class CompanyStatus
{
    const ROOT = "company-status";
    const CREATED_LOCAL = array("type" => self::ROOT, "key" => "created-local", "value" => "Created locally");
    const FAIL_CREATE_LOCAL = array("type" => self::ROOT, "key" => "fail-create-local", "value" => "Failed to create locally");
    const CREATED_REMOTE = array("type" => self::ROOT, "key" => "created-remote", "value" => "Created remotely");
    const FAIL_CREATE_REMOTE = array("type" => self::ROOT, "key" => "failed-create-remote", "value" => "Failed to create remotely");
    const REMOTE_CREATION_IN_PROGRESS = array("type" => self::ROOT, "key" => "remote-creation-in-progress", "value" => "Remote creation in progress");

    public static function all(): array
    {
        return array(self::CREATED_LOCAL, self::FAIL_CREATE_LOCAL, self::CREATED_REMOTE, self::FAIL_CREATE_REMOTE, self::REMOTE_CREATION_IN_PROGRESS);
    }
}
