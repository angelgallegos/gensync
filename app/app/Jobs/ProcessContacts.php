<?php

namespace App\Jobs;

use App\DTOs\ContactsDTO;
use App\Processors\ContactsProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessContacts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ContactsDTO $contacts;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ContactsDTO $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Execute the job.
     *
     * @param ContactsProcessor $contactsProcessor
     * @return void
     */
    public function handle(ContactsProcessor $contactsProcessor): void
    {
        $contactsProcessor->handle($this->contacts);
    }
}
