<?php

namespace SumanIon\TelegramBot\Features;

use SumanIon\TelegramBot\Chat;
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
        $this->processUpdate(new ParsedUpdate($content));
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
     * @param  \SumanIon\TelegramBot\ParsedUpdate $update
     *
     * @return void
     */
    public function processUpdate(ParsedUpdate $update)
    {
        $manager     = get_class($this);
        $update_chat = $update->chat();
        $chat        = Chat::where('manager', $manager)->where('chat_id', $update_chat->id)->first();

        if (!$chat) {

            $chat = Chat::create([
                'manager' => $manager,
                'chat_id' => $update_chat->id,
                'type'    => $update_chat->type,
                'title'   => $update_chat->title
            ]);
        }

        $update = Update::create([
            'manager' => $manager,
            'chat_id' => $chat->id,
            'content' => $update->toJson()
        ]);

        // TODO: actually process the update.
    }
}