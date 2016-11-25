<?php

$router->get('/telegram-bot/webhook/{token}/enable', 'WebhookController@enable');
$router->get('/telegram-bot/webhook/{token}/disable', 'WebhookController@disable');
$router->post('/telegram-bot/webhook/{token}', 'WebhookController@handle');

$router->get('/telegram-bot/{token}', 'TelegramBotController@index');
$router->get('/telegram-bot/{token}/chat/{id}/delete', 'TelegramBotController@deleteChat');
$router->post('/telegram-bot/{token}/ability', 'TelegramBotController@createAbility');
$router->get('/telegram-bot/{token}/ability/{id}/delete', 'TelegramBotController@deleteAbility');
$router->post('/telegram-bot/{token}/chat/{id}/abilities', 'TelegramBotController@updateChatAbilities');
$router->get('/telegram-bot/{token}/update/{id}/delete', 'TelegramBotController@deleteUpdate');