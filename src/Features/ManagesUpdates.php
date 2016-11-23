<?php

namespace SumanIon\TelegramBot\Features;

use SumanIon\TelegramBot\User;
use SumanIon\TelegramBot\Update;
use Illuminate\Support\Collection;
use SumanIon\TelegramBot\ParsedUpdate;

trait ManagesUpdates
{
    /**
     * Handles a new webhook.
     *
     * @param  string $content
     *
     * @return void
     */
    public function webhook(string $content)
    {
        return $this->processUpdate(new ParsedUpdate($content));
    }

    /**
     * Handles new Bot updates.
     *
     * @return void
     */
    public function updates()
    {
        $last_update = Update::where('manager', get_class($this))->orderBy('id', 'desc')->first();
        $updates     = $this->getUpdates($last_update ? $last_update->content->id() + 1 : 0);

        (new Collection($updates))->each([$this, 'processUpdate']);
    }

    /**
     * Processes a new update of the Bot.
     *
     * @param  ParsedUpdate $update
     *
     * @return void
     */
    public function processUpdate(ParsedUpdate $update)
    {
        $from = $update->from();
        $user = User::where('chat_id', $from->id)->first();

        if (!$user) {

            $user = User::create([
                'manager'    => get_class($this),
                'chat_id'    => $from->id,
                'first_name' => $from->first_name,
                'last_name'  => $from->last_name,
                'username'   => $from->username
            ]);
        }

        $update = Update::create([
            'manager' => get_class($this),
            'user_id' => $user->id,
            'content' => $update->toJson()
        ]);

        // TODO: actually process the update.
    }
}