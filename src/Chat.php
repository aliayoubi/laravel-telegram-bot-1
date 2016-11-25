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
        'title',
        'first_name',
        'last_name',
        'username'
    ];

    /**
     * A chat may receive many updates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function updates()
    {
        return $this->hasMany(Update::class, 'chat_id');
    }

    /**
     * A chat may have many requests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(Request::class, 'chat_id');
    }
}