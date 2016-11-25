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
        $last_update = Update::where('manager', $this->name())->orderBy('id', 'desc')->first();
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
        $chat       = $update->chat();
        $saved_chat = Chat::where('manager', $this->name())->where('chat_id', $chat->id)->first();

        // Save a new chat.

        if (!$saved_chat) {

            $saved_chat = Chat::create([
                'manager'    => $this->name(),
                'chat_id'    => $chat->id,
                'type'       => $chat->type,
                'title'      => $chat->title,
                'first_name' => $chat->first_name,
                'last_name'  => $chat->last_name,
                'username'   => $chat->username
            ]);
        }

        // Save a new update.

        $saved_update = Update::create([
            'manager' => $this->name(),
            'chat_id' => $saved_chat->id,
            'content' => $update->toJson()
        ]);

        // Remove the chat if the Bot was removed from the group.

        if ($chat->type === 'group') {

            $left_id = $update->get('message.left_chat_participant.id') ?:
                       $update->get('message.left_chat_member.id');

            if ($left_id) {

                $me = $this->getMe();

                if ($me) {

                    if ($left_id === $me->get('id')) {

                        return $saved_chat->delete();
                    }
                }
            }
        }

        // TODO: actually process the update.
    }
}