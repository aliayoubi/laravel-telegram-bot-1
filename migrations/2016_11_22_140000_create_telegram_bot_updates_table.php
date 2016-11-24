<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramBotUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_bot_updates', function (Blueprint $table) {
            $table->increments('id');

            $table->string('manager');
            $table->integer('chat_id')->unsigned();
            $table->text('content')->nullable();

            $table->timestamps();

            $table->foreign('chat_id')
                  ->references('id')
                  ->on('telegram_bot_chats')
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
        Schema::drop('telegram_bot_updates');
    }
}