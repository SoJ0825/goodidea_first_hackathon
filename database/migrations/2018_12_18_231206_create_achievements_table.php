<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', '10');
            $table->boolean('allWin')->default('0');
            $table->boolean('loss10Time')->default('0');
            $table->boolean('luckyAce')->default('0');
            $table->boolean('poorYou')->default('0');
            $table->boolean('lovelyQueen')->default('0');
            $table->boolean('winTwice_game1')->default('0');
            $table->boolean('play10Time_game1')->default('0');
            $table->boolean('winTwice_game2')->default('0');
            $table->boolean('play10Time_game2')->default('0');
            $table->boolean('winTwice')->default('0');
            $table->boolean('play10Time')->default('0');
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
        Schema::dropIfExists('achievements');
    }
}
