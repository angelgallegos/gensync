<?php

namespace App\Providers;

use App\Clients\GenpoClient;
use App\Repositories\CompanyRepository;
use App\Repositories\ConfigurationsRepository;
use App\Repositories\ContactsRepository;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\ConfigurationsRepositoryInterface;
use App\Repositories\Interfaces\ContactsRepositoryInterface;
use App\Services\Readers\CsvReader;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CsvReader::class, function (Application $app) {
            return new CsvReader();
        });
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(ContactsRepositoryInterface::class, ContactsRepository::class);
        $this->app->bind(ConfigurationsRepositoryInterface::class, ConfigurationsRepository::class);
        $this->app->bind(GenpoClient::class, function (Application $app){
            return new GenpoClient(
                new Client(),
                config('client.uri'),
                config('client.token')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
