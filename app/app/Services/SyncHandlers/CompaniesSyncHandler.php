<?php

namespace App\Services\SyncHandlers;

use App\Jobs\ProcessCompanies;
use App\Services\Models\CompanyService;
use Exception;
use Illuminate\Support\Facades\Log;

class CompaniesSyncHandler implements SyncHandlerInterface
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function sync(): void
    {
        $companies = $this->companyService->listToSync();
        Log::debug("Total size of companies to sync: ".sizeof($companies));
        foreach ($companies as $company) {
            try {
                $this->companyService->markAsSent($company);
                ProcessCompanies::dispatch($company)->afterCommit();
            } catch (Exception $e) {
                Log::error("Exception while creating company: ".$e->getMessage());
                $this->companyService->markAsFailedToSend($company);
            }
        }
    }
}
