<?php

namespace App\Jobs;

use App\DTOs\CompanyDTO;
use App\Processors\CompanyProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCompanies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected CompanyDTO $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CompanyDTO $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     * @param CompanyProcessor $companyProcessor
     * @return void
     */
    public function handle(CompanyProcessor $companyProcessor): void
    {
        $companyProcessor->handle($this->company);
    }
}
