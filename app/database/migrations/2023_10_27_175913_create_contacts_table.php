<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->collation('utf8mb4_unicode_ci');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->dateTime('date_of_birth');
            $table->string('error_message')->nullable();
            $table->foreignUuid('company_id')->nullable()->index()->references("id")->on("companies")->nullOnDelete();
            $table->foreignUuid('status_id')->nullable()->index()->references("id")->on("configurations")->nullOnDelete();
            $table->json('response')->nullable();
            $table->string("contact_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
