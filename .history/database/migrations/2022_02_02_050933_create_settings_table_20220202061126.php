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
            $table->string('company_name')->default('Betalaptops');
            'company_name' => 'Betalaptops',
            'official_email' => 'info@betalaptops.com',
            'currency' => '₦',
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
