<?php

namespace App\Repositories;

use App\DTOs\ContactsDTO;
use App\Models\Configuration\Configuration;
use App\Models\Contacts;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ContactsRepository implements Interfaces\ContactsRepositoryInterface
{

    public function all(): Collection
    {
        return Contacts::all();
    }

    public function store(?string $id, ContactsDTO $contactsDTO, Configuration $configuration, ?Company $company): Contacts
    {
        $contact = Contacts::find($id);

        if(is_null($id)) {
            $contact = new Contacts();
        }

        if (is_null($company)) {
            $contactsDTO->setCompanyId(null);
        }
        $contact->fill($contactsDTO->toArray());
        $contact->company()->associate($company);
        $contact->status()->associate($configuration);
        $contact->save();

        //$contact->update($contactsDTO->toArray());
        //$contact->status()->associate($configuration);

        return $contact;
    }

    public function find(string $id): ?Contacts
    {
        return Contacts::find($id);
    }

    public function updateStatus(ContactsDTO $contactsDTO, Configuration $status): Contacts
    {
        $contacts = $this->find($contactsDTO->getId());
        $contacts->status()->associate($status);
        $contacts->save();

        return $contacts;
    }

    public function listByStatus(Configuration $status)
    {
        return Contacts::where("status_id", $status->id)->limit(40)->orderBy("created_at", "desc")->get();
    }

    public function listByStatusAndCompanyStatus(Configuration $status, Configuration $companyStatus)
    {
        return Contacts::where("status_id", $status->id)->whereHas('company', function(Builder $query) use ($companyStatus) {
            $query->where('status_id', $companyStatus->id);
        })->limit(40)->orderBy("created_at", "desc")->get();
    }
}
