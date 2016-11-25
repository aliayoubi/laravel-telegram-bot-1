<?php

namespace SumanIon\TelegramBot\Controllers;

use Illuminate\Http\Request;
use SumanIon\TelegramBot\Manager;
use Illuminate\Support\Facades\URL;

class WebhookController extends Controller
{
    /**
     * Enables webhook for a Bot.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $token
     *
     * @return string
     */
    public function enable(Request $request, $token)
    {
        $this->findManager($token);

        $bot  = $this->manager;
        $bots = Manager::findAllManagers();
        $type = 'ssl';
        $show = 'enable';

        if (!$request->secure() and $request->server('HTTP_X_FORWARDED_PROTO') !== 'https') {

            return view('telegram::webhook', compact('bot', 'bots', 'type', 'token', 'show'));
        }

        $this->manager->setWebhook(URL::to("/api/telegram-bot/webhook/{$token}", null, true));

        $type = 'enabled';

        return view('telegram::webhook', compact('bot', 'bots', 'type', 'token', 'show'));
    }

    /**
     * Disables webhook for a Bot.
     *
     * @param  string $token
     *
     * @return string
     */
    public function disable($token)
    {
        $this->findManager($token);

        $this->manager->setWebhook('');

        $bot  = $this->manager;
        $bots = Manager::findAllManagers();
        $type = 'disabled';
        $show = 'disable';

        return view('telegram::webhook', compact('bot', 'bots', 'type', 'token', 'show'));
    }

    /**
     * Handles a new webhook.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $token
     *
     * @return string
     */
    public function handle(Request $request, $token)
    {
        $this->findManager($token);

        $this->manager->webhook($request->getContent());

        return 'OK';
    }
}