<?php

namespace SumanIon\TelegramBot;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Features\ManagesUserAbilities;

    /** @var string */
    protected $table = 'telegram_bot_users';

    /** @var array */
    protected $fillable = [
        'manager',
        'chat_id',
        'first_name',
        'last_name',
        'username'
    ];
}