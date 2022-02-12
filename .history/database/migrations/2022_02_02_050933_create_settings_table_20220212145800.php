<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo')->default('site/assets/images/general/logo.png');
            $table->string('favicon')->default('site/assets/images/general/favicon.png');
            $table->string('company_name')->default('Betalaptops');
            $table->string('official_email')->default('info@betalaptops.com');
            $table->string('official_account_name')->default('Beta Laptop')->nullable();
            $table->string('official_account_name')->default('Beta Laptop')->nullable();
            $table->string('official_account_number')->default('info@betalaptops.com')->nullable();

            
            $table->string('currency')->default('₦');

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
        Schema::dropIfExists('settings');
    }
}
