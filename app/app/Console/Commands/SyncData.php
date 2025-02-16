<?php

namespace App\Console\Commands;

use App\Services\SyncHandlers\SyncHandlerMap;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class SyncData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:genpo {dataType}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the local data to Genpo';

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
        $syncHandler = App::make(SyncHandlerMap::getHandler($this->argument("dataType")));
        $syncHandler->sync();
    }
}
