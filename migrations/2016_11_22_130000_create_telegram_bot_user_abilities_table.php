<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramBotUserAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_bot_user_abilities', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->integer('ability_id')->unsigned()->index();

            $table->timestamps();

            $table->unique(['user_id', 'ability_id']);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('telegram_bot_users')
                  ->onDelete('cascade');

            $table->foreign('ability_id')
                  ->references('id')
                  ->on('telegram_bot_abilities')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('telegram_bot_user_abilities');
    }
}