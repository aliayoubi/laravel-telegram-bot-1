<?php

namespace SumanIon\TelegramBot\Controllers;

use Illuminate\Http\Request;
use SumanIon\TelegramBot\Manager;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

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
        $manager = Manager::findManagerWithToken($token);

        if (!$manager) {

            return Container::getInstance()->abort(404);
        }

        if (!$request->secure() and $request->server('HTTP_X_FORWARDED_PROTO') !== 'https') {

            return 'To enable webhook, please visit this page using HTTPS.
                    <br><b>Note:</b> You must have a valid SSL certificate to be able to use webhook.';
        }

        $manager->setWebhook(URL::to("/api/telegram-bot/webhook/{$token}", null, true));

        return 'Webhook was successfully <b>enabled</b> for [<b>' . get_class($manager) . '</b>]
                <br><b>Note:</b> You will not be able to receive updates using getUpdates for as long as an outgoing webhook is set up.';
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
        $manager = Manager::findManagerWithToken($token);

        if (!$manager) {

            return Container::getInstance()->abort(404);
        }

        $manager->setWebhook('');

        return 'Webhook was successfully <b>disabled</b> for [<b>' . get_class($manager) . '</b>]
                <br><b>Note:</b> Now you should handle incoming updates manually.';
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
        $manager = Manager::findManagerWithToken($token);

        if (!$manager) {

            return Container::getInstance()->abort(404);
        }

        $manager->webhook($request->getContent());

        return 'OK';
    }
}