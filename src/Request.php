<?php

namespace SumanIon\TelegramBot;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    /** @var string */
    protected $table = 'telegram_bot_requests';

    /** @var array */
    protected $fillable = [
        'manager',
        'chat_id',
        'type',
        'url',
        'fields',
        'response'
    ];
}