<?php

namespace SumanIon\TelegramBot;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use Features\ManagesChatAbilities;

    /** @var string */
    protected $table = 'telegram_bot_chats';

    /** @var array */
    protected $fillable = [
        'manager',
        'chat_id',
        'type',
        'title'
    ];
}