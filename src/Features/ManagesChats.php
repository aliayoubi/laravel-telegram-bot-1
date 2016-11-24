<?php

namespace SumanIon\TelegramBot\Features;

use closure;
use SumanIon\TelegramBot\Chat;

trait ManagesChats
{
    /**
     * Lists all chats of the Bot.
     *
     * @param  closure|null $custom
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function chats(closure $custom = null)
    {
        $query = Chat::with('abilities')->where('manager', get_class($this));

        if ($custom) {

            return $custom($query);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    /**
     * Returns chat id of the given chat.
     *
     * @param  mixed $chat
     *
     * @return int
     */
    public function chatId($chat):int
    {
        return $chat instanceof Chat ? $chat->chat_id : (int)$chat;
    }
}