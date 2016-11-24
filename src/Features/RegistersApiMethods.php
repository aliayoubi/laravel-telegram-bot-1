<?php

namespace SumanIon\TelegramBot\Features;

use Illuminate\Support\Facades\Queue;
use SumanIon\TelegramBot\ParsedUpdate;
use SumanIon\TelegramBot\Jobs\SendRequest;
use SumanIon\TelegramBot\Methods\AdvancedMessage;
use SumanIon\TelegramBot\Methods\AdvancedAudioMessage;
use SumanIon\TelegramBot\Methods\AdvancedPhotoMessage;
use SumanIon\TelegramBot\Methods\AdvancedVenueMessage;
use SumanIon\TelegramBot\Methods\AdvancedVideoMessage;
use SumanIon\TelegramBot\Methods\AdvancedVoiceMessage;
use SumanIon\TelegramBot\Methods\AdvancedContactMessage;
use SumanIon\TelegramBot\Methods\AdvancedStickerMessage;
use SumanIon\TelegramBot\Methods\AdvancedDocumentMessage;
use SumanIon\TelegramBot\Methods\AdvancedLocationMessage;

trait RegistersApiMethods
{
    /**
     * Returns basic information about current bot.
     *
     * @return bool|\SumanIon\TelegramBot\ParsedUpdate
     */
    public function getMe():ParsedUpdate
    {
        return current($this->sendRequest('GET', 'getMe'));
    }

    /**
     * Returns latest updates of the Bot.
     *
     * @param  int    $offset
     * @param  int    $limit
     * @param  int    $timeout
     *
     * @return array
     */
    public function getUpdates(int $offset = 0, int $limit = 100, int $timeout = 0):array
    {
        return $this->sendRequest('GET', 'getUpdates', [
            'offset'  => $offset,
            'limit'   => $limit,
            'timeout' => $timeout
        ]);
    }

    /**
     * Specifies an url to receive incoming updates via an outgoing webhook.
     *
     * @param  string $url
     *
     * @return bool|\SumanIon\TelegramBot\ParsedUpdate
     */
    public function setWebhook(string $url = ''):ParsedUpdate
    {
        return current($this->sendRequest('GET', 'setWebhook', [
            'url' => $url
        ]));
    }

    /**
     * Returns information about current status of webhook.
     *
     * @return bool|\SumanIon\TelegramBot\ParsedUpdate
     */
    public function getWebhookInfo():ParsedUpdate
    {
        return current($this->sendRequest('GET', 'getWebhookInfo'));
    }

    /**
     * Lists profile pictures of a user.
     *
     * @param  int $user_id
     * @param  int $offset
     * @param  int $limit
     *
     * @return bool|\SumanIon\TelegramBot\ParsedUpdate
     */
    public function getUserProfilePhotos(int $user_id, int $offset = 0, int $limit = 100)
    {
        return current($this->sendRequest('GET', 'getUserProfilePhotos', [
            'user_id' => $user_id
        ]));
    }

    /**
     * Gets basic information about a file and prepares it for download.
     *
     * @param  string $file_id
     *
     * @return bool|\SumanIon\TelegramBot\ParsedUpdate
     */
    public function getFile(string $file_id)
    {
        return current($this->sendRequest('GET', 'getFile', [
            'file_id' => $file_id
        ]));
    }

    /**
     * Sends some information to a chat.
     *
     * @param  string $type
     * @param  string $method
     * @param  array  $options
     * @param  array  $fields
     *
     * @return void
     */
    public function sendInfo(string $type, string $method, array $options = [], array $fields = [])
    {
        Queue::push(new SendRequest($type, $this->url($method, $options), $fields));
    }

    /**
     * Sends a message to a chat.
     *
     * @param  mixed  $chat
     * @param  string $text
     * @param  array  $options
     *
     * @return void
     */
    public function sendMessage($chat, string $text = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedMessage($this, $chat);
        }

        $options['chat_id'] = $this->chatId($chat);
        $options['text']    = $text;

        $this->sendInfo('GET', 'sendMessage', $options);
    }

    /**
     * Forwards a message to a chat.
     *
     * @param  mixed  $chat
     * @param  int    $from_chat_id
     * @param  int    $message_id
     * @param  bool   $disable_notification
     *
     * @return void
     */
    public function forwardMessage($chat, int $from_chat_id, int $message_id, bool $disable_notification = false)
    {
        $this->sendInfo('GET', 'forwardMessage', [
            'chat_id'              => $this->chatId($chat),
            'from_chat_id'         => $from_chat_id,
            'message_id'           => $message_id,
            'disable_notification' => $disable_notification
        ]);
    }

    /**
     * Sends a photo to a chat.
     *
     * @param  mixed  $chat
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendPhoto($chat, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedPhotoMessage($this, $chat);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($chat);
        $options['caption'] = $caption;

        if (filter_var($location, FILTER_VALIDATE_URL) !== false or !is_file($location)) {

            $options['photo'] = $location;
        } else {

            $type = 'POST';
            $fields['multipart'] = [
                [
                    'name' => 'photo',
                    'contents' => $location
                ]
            ];
        }

        $this->sendInfo($type, 'sendPhoto', $options, $fields);
    }

    /**
     * Sends an audio file to a chat.
     *
     * @param  mixed  $chat
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendAudio($chat, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedAudioMessage($this, $chat);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($chat);
        $options['caption'] = $caption;

        if (filter_var($location, FILTER_VALIDATE_URL) !== false or !is_file($location)) {

            $options['audio'] = $location;
        } else {

            $type = 'POST';
            $fields['multipart'] = [
                [
                    'name' => 'audio',
                    'contents' => $location
                ]
            ];
        }

        $this->sendInfo($type, 'sendAudio', $options, $fields);
    }

    /**
     * Sends a document to a chat.
     *
     * @param  mixed  $chat
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendDocument($chat, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedDocumentMessage($this, $chat);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($chat);
        $options['caption'] = $caption;

        if (filter_var($location, FILTER_VALIDATE_URL) !== false or !is_file($location)) {

            $options['document'] = $location;
        } else {

            $type = 'POST';
            $fields['multipart'] = [
                [
                    'name' => 'document',
                    'contents' => $location
                ]
            ];
        }

        $this->sendInfo($type, 'sendDocument', $options, $fields);
    }

    /**
     * Sends a sticker to a chat.
     *
     * @param  mixed  $chat
     * @param  string $location
     * @param  array  $options
     *
     * @return void
     */
    public function sendSticker($chat, string $location = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedStickerMessage($this, $chat);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($chat);

        if (filter_var($location, FILTER_VALIDATE_URL) !== false or !is_file($location)) {

            $options['sticker'] = $location;
        } else {

            $type = 'POST';
            $fields['multipart'] = [
                [
                    'name' => 'sticker',
                    'contents' => $location
                ]
            ];
        }

        $this->sendInfo($type, 'sendSticker', $options, $fields);
    }

    /**
     * Sends a video file to a chat.
     *
     * @param  mixed  $chat
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendVideo($chat, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedVideoMessage($this, $chat);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($chat);
        $options['caption'] = $caption;

        if (filter_var($location, FILTER_VALIDATE_URL) !== false or !is_file($location)) {

            $options['video'] = $location;
        } else {

            $type = 'POST';
            $fields['multipart'] = [
                [
                    'name' => 'video',
                    'contents' => $location
                ]
            ];
        }

        $this->sendInfo($type, 'sendVideo', $options, $fields);
    }

    /**
     * Sends a voice file to a chat.
     *
     * @param  mixed  $chat
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendVoice($chat, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedVoiceMessage($this, $chat);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($chat);
        $options['caption'] = $caption;

        if (filter_var($location, FILTER_VALIDATE_URL) !== false or !is_file($location)) {

            $options['voice'] = $location;
        } else {

            $type = 'POST';
            $fields['multipart'] = [
                [
                    'name' => 'voice',
                    'contents' => $location
                ]
            ];
        }

        $this->sendInfo($type, 'sendVoice', $options, $fields);
    }

    /**
     * Sends a location to a chat.
     *
     * @param  mixed $chat
     * @param  float $latitude
     * @param  float $longitude
     * @param  array $options
     *
     * @return void
     */
    public function sendLocation($chat, float $latitude = 0, float $longitude = 0, array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedLocationMessage($this, $chat);
        }

        $options['chat_id']   = $this->chatId($chat);
        $options['latitude']  = $latitude;
        $options['longitude'] = $longitude;

        $this->sendInfo('GET', 'sendLocation', $options);
    }

    /**
     * Sends a venue to a chat.
     *
     * @param  mixed  $user
     * @param  float  $latitude
     * @param  float  $longitude
     * @param  string $title
     * @param  string $address
     * @param  array  $options
     *
     * @return void
     */
    public function sendVenue($chat, float $latitude = 0, float $longitude = 0, string $title = '', string $address = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedVenueMessage($this, $chat);
        }

        $options['chat_id']   = $this->chatId($chat);
        $options['latitude']  = $latitude;
        $options['longitude'] = $longitude;
        $options['title']     = $title;
        $options['address']   = $address;

        $this->sendInfo('GET', 'sendVenue', $options);
    }

    /**
     * Sends a contact to a chat.
     *
     * @param  mixed  $chat
     * @param  string $phone_number
     * @param  string $first_name
     * @param  string $last_name
     * @param  array  $options
     *
     * @return void
     */
    public function sendContact($chat, string $phone_number = '', string $first_name = '', string $last_name = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedContactMessage($this, $chat);
        }

        $options['chat_id']      = $this->chatId($chat);
        $options['phone_number'] = $phone_number;
        $options['first_name']   = $first_name;
        $options['last_name']    = $last_name;

        $this->sendInfo('GET', 'sendContact', $options);
    }

    /**
     * Sends a chat action to a chat.
     *
     * @param  mixed  $chat
     * @param  string $action
     *
     * @return void
     */
    public function sendChatAction($chat, string $action)
    {
        $actions = [
            'typing', 'upload_photo', 'record_video',
            'upload_video', 'record_audio', 'upload_audio',
            'upload_document', 'find_location'
        ];

        if (!in_array($action, $actions)) {
            return;
        }

        $options = [
            'chat_id' => $this->chatId($chat),
            'action'  => $action
        ];

        $this->sendInfo('GET', 'sendChatAction', $options);
    }
}