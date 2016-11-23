<?php

namespace SumanIon\TelegramBot\Features;

use closure;
use SumanIon\TelegramBot\User;

trait ManagesUsers
{
    /**
     * Lists users of the bot.
     *
     * @param  closure|null $custom
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function users(closure $custom = null)
    {
        $query = User::with('abilities')->where('manager', get_class($this));

        if ($custom) {

            return $custom($query);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    /**
     * Returns chat id of the given user.
     *
     * @param  mixed $user
     *
     * @return int
     */
    public function chatId($user):int
    {
        return $user instanceof User ? $user->chat_id : (int)$user;
    }
}