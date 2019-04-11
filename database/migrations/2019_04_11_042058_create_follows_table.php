<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();         // Mày là thằng nào
            $table->integer('user_id_follow')->unsigned(); //Mày đang theo dõi ai
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_id_follow')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
