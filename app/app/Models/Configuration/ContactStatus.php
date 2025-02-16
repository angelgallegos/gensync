<?php

namespace App\Models\Configuration;

class ContactStatus
{
    const ROOT = "contact-status";
    const CREATED_LOCAL = array("type" => self::ROOT, "key" => "created-local", "value" => "Created locally");
    const FAIL_CREATE_LOCAL = array("type" => self::ROOT, "key" => "fail-create-local", "value" => "Failed to create locally");
    const FAIL_TO_SEND_TO_CREATE = array("type" => self::ROOT, "key" => "fail-send-to-create", "value" => "Failed to send to create remotely");
    const CREATED_REMOTE = array("type" => self::ROOT, "key" => "created-remote", "value" => "Created remotely");
    const FAIL_CREATE_REMOTE = array("type" => self::ROOT, "key" => "failed-remote", "value" => "Failed to create remotely");
    const REMOTE_CREATION_IN_PROGRESS = array("type" => self::ROOT, "key" => "remote-creation-in-progress", "value" => "Remote creation in progress");
    const ATTACHING_IN_PROGRESS = array("type" => self::ROOT, "key" => "attaching-in-progress", "value" => "Attaching to profile in progress");
    const ATTACHING_FAILED = array("type" => self::ROOT, "key" => "attaching-failed", "value" => "Attaching to profile failed");
    const ATTACHING_SUCCESS = array("type" => self::ROOT, "key" => "attaching-success", "value" => "Attaching to profile succeeded");
    const FAIL_TO_SEND_TO_ATTACH = array("type" => self::ROOT, "key" => "fail-send-to-attach", "value" => "Failed to send to attach to profile");

    public static function all(): array
    {
        return array(
            self::CREATED_LOCAL,
            self::FAIL_CREATE_LOCAL,
            self::FAIL_TO_SEND_TO_CREATE,
            self::CREATED_REMOTE,
            self::FAIL_CREATE_REMOTE,
            self::REMOTE_CREATION_IN_PROGRESS,
            self::FAIL_TO_SEND_TO_ATTACH,
            self::ATTACHING_IN_PROGRESS,
            self::ATTACHING_FAILED,
            self::ATTACHING_SUCCESS
        );
    }
}
