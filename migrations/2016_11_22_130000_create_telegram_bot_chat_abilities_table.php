<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramBotChatAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_bot_chat_abilities', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('chat_id')->unsigned()->index();
            $table->integer('ability_id')->unsigned()->index();

            $table->timestamps();

            $table->unique(['chat_id', 'ability_id']);

            $table->foreign('chat_id')
                  ->references('id')
                  ->on('telegram_bot_chats')
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
        Schema::drop('telegram_bot_chat_abilities');
    }
}