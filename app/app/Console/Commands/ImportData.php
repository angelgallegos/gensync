<?php

namespace App\Console\Commands;

use App\Services\ImportHandlers\ImportHandlerMap;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data {dataType} {fullPath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports specified data type from a csv file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        Log::debug("Starting sync of data type {$this->argument("dataType")}");
        $importHandler = App::make(ImportHandlerMap::getHandler($this->argument("dataType")));
        $importHandler->import($this->argument('fullPath'));
    }
}
