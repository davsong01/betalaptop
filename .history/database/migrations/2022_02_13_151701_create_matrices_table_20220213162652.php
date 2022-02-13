<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matrices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('position'); // 1, 2,4,5,6 representing different positions or levels of a user
            $table->text('left')->nullable(); // json associative array of downlines (e.g. 1=>['12',4], 2=>['3',7]) 
            $table->text('right')->nullable();
            
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
        Schema::dropIfExists('matrices');
    }
}
