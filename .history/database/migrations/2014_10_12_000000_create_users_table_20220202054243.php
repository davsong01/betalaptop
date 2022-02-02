<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username');
            $table->integer('upline')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('sponsor_id')->nullable();
            $table->integer('direct_downlines')->nullable();
            $table->integer('level')->nullable();
            $table->integer('two')->nullable();
            $table->integer('three')->nullable();
            $table->integer('four')->nullable();
            $table->integer('five')->nullable();
            $table->integer('sic')->nullable();
            

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
