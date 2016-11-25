<?php

$router->get('/telegram-bot/webhook/{token}/enable', 'WebhookController@enable');
$router->get('/telegram-bot/webhook/{token}/disable', 'WebhookController@disable');
$router->post('/telegram-bot/webhook/{token}', 'WebhookController@handle');

$router->get('/telegram-bot/{token}', 'TelegramBotController@index');
$router->get('/telegram-bot/{token}/{id}/delete', 'TelegramBotController@deleteChat');
$router->post('/telegram-bot/{token}/create-ability', 'TelegramBotController@createAbility');
$router->get('/telegram-bot/{token}/delete-ability/{id}', 'TelegramBotController@deleteAbility');
$router->post('/telegram-bot/{token}/{id}/abilities', 'TelegramBotController@updateChatAbilities');