<?php

namespace App\Repositories\Interfaces;

use App\DTOs\ContactsDTO;
use App\Models\Company;
use App\Models\Configuration\Configuration;
use App\Models\Contacts;
use Illuminate\Database\Eloquent\Collection;

interface ContactsRepositoryInterface
{
    public function all(): Collection;
    public function store(?string $id, ContactsDTO $contactsDTO, Configuration $configuration, ?Company $company): Contacts;
    public function find(string $id);
}
