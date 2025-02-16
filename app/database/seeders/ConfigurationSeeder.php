<?php

namespace Database\Seeders;

use App\Models\Configuration\CompanyStatus;
use App\Models\Configuration\Configuration;
use App\Models\Configuration\ContactStatus;
use Illuminate\Database\Seeder;


class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (CompanyStatus::all() as $value) {
            Configuration::factory()->create(
                [
                    "key" => $value["key"],
                    "value" => $value["value"],
                    "type" => $value["type"]
                ]
            );
        }

        foreach (ContactStatus::all() as $value) {
            Configuration::factory()->create(
                [
                    "key" => $value["key"],
                    "value" => $value["value"],
                    "type" => $value["type"]
                ]
            );
        }

    }
}
