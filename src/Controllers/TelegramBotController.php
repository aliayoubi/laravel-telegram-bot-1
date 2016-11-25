<?php

namespace SumanIon\TelegramBot\Controllers;

use Illuminate\Http\Request;
use SumanIon\TelegramBot\Chat;
use SumanIon\TelegramBot\Ability;
use SumanIon\TelegramBot\Manager;
use SumanIon\TelegramBot\Request as BotRequest;

class TelegramBotController extends Controller
{
    /**
     * Telegram Bot Manager's home page.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $token
     *
     * @return mixed
     */
    public function index(Request $request, $token)
    {
        $this->findManager($token);

        $bot  = $this->manager;
        $bots = Manager::findAllManagers();
        $show = $request->input('show') ?: 'overview';

        return view('telegram::index', compact('bot', 'bots', 'token', 'show'));
    }

    /**
     * Deletes a chat.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $token
     * @param  int                      $id
     *
     * @return mixed
     */
    public function deleteChat(Request $request, $token, $id)
    {
        $this->findManager($token);

        $chat = Chat::where('id', $id)->firstOrFail();
        $chat->delete();

        return redirect("/api/telegram-bot/{$token}?show=chats&page={$request->input('page')}");
    }

    /**
     * Creates a new ability.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $token
     *
     * @return mixed
     */
    public function createAbility(Request $request, $token)
    {
        $this->findManager($token);

        $name = $request->input('name');

        if (is_string($name) and !empty($name)) {
            Ability::firstOrCreate([ 'name' => substr($name, 0, 100) ]);
        }

        return redirect("/api/telegram-bot/{$token}");
    }

    /**
     * Deletes an ability.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $token
     * @param  int                      $id
     *
     * @return mixed
     */
    public function deleteAbility(Request $request, $token, $id)
    {
        $this->findManager($token);

        $ability = Ability::where('id', $id)->firstOrFail();

        $ability->delete();

        return redirect("/api/telegram-bot/{$token}");
    }

    /**
     * Updates abilities of a chat.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $token
     * @param  int                      $id
     *
     * @return mixed
     */
    public function updateChatAbilities(Request $request, $token, $id)
    {
        $this->findManager($token);

        $chat = Chat::where('id', $id)->firstOrFail();

        $chat->abilities()->sync((array)$request->input('abilities'));

        return redirect("/api/telegram-bot/{$token}?show=chats&page={$request->input('page')}");
    }
}