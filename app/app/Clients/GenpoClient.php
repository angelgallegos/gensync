<?php

namespace App\Clients;

use App\DTOs\CompanyDTO;
use App\DTOs\ConfigurationDTO;
use App\DTOs\ContactsDTO;
use App\Models\Configuration\CompanyStatus;
use App\Models\Configuration\ContactStatus;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GenpoClient
{
    private Client $client;

    private string $uri;

    private string $token;

    public function __construct(
        Client $client,
        string $uri,
        string $token
    )
    {
        $this->client = $client;
        $this->uri = $uri;
        $this->token = $token;
    }

    /**
     */
    public function createCompany(CompanyDTO $companyDTO): CompanyDTO
    {
        try {
            $response = $this->client->request('POST', "$this->uri/profiles", [
                'body' => $companyDTO->toRequestJson(),
                'headers' => [
                    'Authorization' => "Bearer $this->token",
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            $companyDTO->setResponse($response->getBody());
            if ($response->getStatusCode() == 201) {
                $newStatus = $this->newStatus(CompanyStatus::CREATED_REMOTE);
                $contents = json_decode((string) $response->getBody());
                $companyDTO->setProfileId($contents->id);
            } else {
                $newStatus = $this->newStatus(CompanyStatus::FAIL_CREATE_REMOTE);
            }
            $companyDTO->setStatus($newStatus);

        } catch (GuzzleException $exception) {
            $this->newStatus(CompanyStatus::FAIL_CREATE_REMOTE);
            $companyDTO->setErrorMessage("Error happened while creating the company");
            $response = $exception->getResponse();
            $companyDTO->setResponse($response->getBody()->getContents());
        }

        return $companyDTO;
    }

    public function createContact(ContactsDTO $contactsDTO): ContactsDTO
    {
        try {
            $response = $this->client->request('POST', "$this->uri/channels/{$contactsDTO->getChannelId()}/contacts", [
                'body' => $contactsDTO->toRequestJson(),
                'headers' => [
                    'Authorization' => "Bearer $this->token",
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            $contactsDTO->setResponse($response->getBody());
            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 200) {
                $newStatus = $this->newStatus(ContactStatus::CREATED_REMOTE);
                $contents = json_decode((string) $response->getBody());
                $contactsDTO->setContactId($contents->id);
            } else {
                $newStatus = $this->newStatus(ContactStatus::FAIL_CREATE_REMOTE);
            }
        } catch (GuzzleException $exception) {
            $newStatus = $this->newStatus(ContactStatus::FAIL_CREATE_REMOTE);
            $response = $exception->getResponse();
            $contactsDTO->setResponse($response->getBody()->getContents());
            $contactsDTO->setErrorMessage("Error happened while creating the contact");
        }
        $contactsDTO->setStatus($newStatus);

        return $contactsDTO;
    }

    public function attachContactToProfile(ContactsDTO $contactsDTO): ContactsDTO
    {
        try {
            $response = $this->client->request('POST', "$this->uri/profiles/{$contactsDTO->getProfileId()}/contacts", [
                'body' => json_encode(array(
                    "contact_id" => $contactsDTO->getContactId(),
                    "type" => "EMAIL"
                )),
                'headers' => [
                    'Authorization' => "Bearer $this->token",
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            $contactsDTO->setResponse($response->getBody());
            if ($response->getStatusCode() == 200) {
                $newStatus = $this->newStatus(ContactStatus::ATTACHING_SUCCESS);
            } else {
                $newStatus = $this->newStatus(ContactStatus::ATTACHING_FAILED);
            }
        } catch (GuzzleException $exception) {
            $newStatus = $this->newStatus(ContactStatus::ATTACHING_FAILED);
            $contactsDTO->setErrorMessage("Error happened while attaching the contact to the profile");
            $response = $exception->getResponse();
            $contactsDTO->setResponse($response->getBody()->getContents());
        }

        $contactsDTO->setStatus($newStatus);

        return $contactsDTO;
    }

    private function newStatus(array $config): ConfigurationDTO
    {
        $status = new ConfigurationDTO();
        $status->setType($config["type"]);
        $status->setKey($config["key"]);
        $status->setValue($config["value"]);

        return $status;
    }
}
