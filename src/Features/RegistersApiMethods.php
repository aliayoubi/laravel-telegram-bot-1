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
     * @param  mixed  $user
     * @param  int    $offset
     * @param  int    $limit
     *
     * @return bool|\SumanIon\TelegramBot\ParsedUpdate
     */
    public function getUserProfilePhotos($user, int $offset = 0, int $limit = 100)
    {
        return current($this->sendRequest('GET', 'getUserProfilePhotos', [
            'user_id' => $this->chatId($user)
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
     * Send some information to a bot user.
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
     * Sends a message to a bot user.
     *
     * @param  mixed  $user
     * @param  string $text
     * @param  array  $options
     *
     * @return void
     */
    public function sendMessage($user, string $text = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedMessage($this, $user);
        }

        $options['chat_id'] = $this->chatId($user);
        $options['text']    = $text;

        $this->sendInfo('GET', 'sendMessage', $options);
    }

    /**
     * Forwards a message to a bot user.
     *
     * @param  mixed  $user
     * @param  int    $from_chat_id
     * @param  int    $message_id
     * @param  bool   $disable_notification
     *
     * @return void
     */
    public function forwardMessage($user, int $from_chat_id, int $message_id, bool $disable_notification = false)
    {
        $this->sendInfo('GET', 'forwardMessage', [
            'chat_id'              => $this->chatId($user),
            'from_chat_id'         => $from_chat_id,
            'message_id'           => $message_id,
            'disable_notification' => $disable_notification
        ]);
    }

    /**
     * Sends a photo to a bot user.
     *
     * @param  mixed  $user
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendPhoto($user, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedPhotoMessage($this, $user);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($user);
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
     * Sends an audio file to a bot user.
     *
     * @param  mixed  $user
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendAudio($user, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedAudioMessage($this, $user);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($user);
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
     * Sends a document to a bot user.
     *
     * @param  mixed  $user
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendDocument($user, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedDocumentMessage($this, $user);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($user);
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
     * Sends a sticker to a bot user.
     *
     * @param  mixed  $user
     * @param  string $location
     * @param  array  $options
     *
     * @return void
     */
    public function sendSticker($user, string $location = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedStickerMessage($this, $user);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($user);

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
     * Sends a video file to a bot user.
     *
     * @param  mixed  $user
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendVideo($user, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedVideoMessage($this, $user);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($user);
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
     * Sends a voice file to a bot user.
     *
     * @param  mixed  $user
     * @param  string $location
     * @param  string $caption
     * @param  array  $options
     *
     * @return void
     */
    public function sendVoice($user, string $location = '', string $caption = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedVoiceMessage($this, $user);
        }

        $type               = 'GET';
        $fields             = [];
        $options['chat_id'] = $this->chatId($user);
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
     * Sends a location to a bot user.
     *
     * @param  mixed $user
     * @param  float $latitude
     * @param  float $longitude
     * @param  array $options
     *
     * @return void
     */
    public function sendLocation($user, float $latitude = 0, float $longitude = 0, array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedLocationMessage($this, $user);
        }

        $options['chat_id']   = $this->chatId($user);
        $options['latitude']  = $latitude;
        $options['longitude'] = $longitude;

        $this->sendInfo('GET', 'sendLocation', $options);
    }

    /**
     * Sends a venue to a bot user.
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
    public function sendVenue($user, float $latitude = 0, float $longitude = 0, string $title = '', string $address = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedVenueMessage($this, $user);
        }

        $options['chat_id']   = $this->chatId($user);
        $options['latitude']  = $latitude;
        $options['longitude'] = $longitude;
        $options['title']     = $title;
        $options['address']   = $address;

        $this->sendInfo('GET', 'sendVenue', $options);
    }

    /**
     * Sends a contact to a bot user.
     *
     * @param  mixed  $user
     * @param  string $phone_number
     * @param  string $first_name
     * @param  string $last_name
     * @param  array  $options
     *
     * @return void
     */
    public function sendContact($user, string $phone_number = '', string $first_name = '', string $last_name = '', array $options = [])
    {
        if (func_num_args() === 1) {
            return new AdvancedContactMessage($this, $user);
        }

        $options['chat_id']      = $this->chatId($user);
        $options['phone_number'] = $phone_number;
        $options['first_name']   = $first_name;
        $options['last_name']    = $last_name;

        $this->sendInfo('GET', 'sendContact', $options);
    }

    /**
     * Sends a chat action to a bot user.
     *
     * @param  mixed  $user
     * @param  string $action
     *
     * @return void
     */
    public function sendChatAction($user, string $action)
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
            'chat_id' => $this->chatId($user),
            'action'  => $action
        ];

        $this->sendInfo('GET', 'sendChatAction', $options);
    }
}