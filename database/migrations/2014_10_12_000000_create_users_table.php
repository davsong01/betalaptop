<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
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
            $table->integer('role')->default('2'); //user=2, manager=4,admin=1,staff=3
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('upline')->nullable();
            $table->foreign('upline')->references('id')->on('users')
            ->onDelete('SET NULL');
            $table->unsignedBigInteger('parent')->nullable(); // [null, null]
            $table->foreign('parent')->references('id')->on('users')
           ->onDelete('set null');
            $table->unsignedBigInteger('sibling')->nullable();
            $table->foreign('sibling')->references('id')->on('users')
           ->onDelete('set null');
            $table->json('children')->nullable();
            $table->integer('level')->default(1)->nullable();
            $table->integer('parent_id')->nullable();
            $table->json('uplines')->nullable();
            // $table->integer('sponsor_id')->nullable();
            // $table->integer('direct_downlines')->nullable();
            // $table->integer('level')->nullable();
            // $table->integer('two')->nullable();
            // $table->integer('three')->nullable();
            // $table->integer('four')->nullable();
            // $table->integer('five')->nullable();
            // $table->integer('six')->nullable();
            $table->string('avatar')->nullable();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('enrolled_by')->nullable();

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
