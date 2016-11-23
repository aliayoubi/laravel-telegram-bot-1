<?php

namespace SumanIon\TelegramBot\Methods;

use SumanIon\TelegramBot\Manager;

class AdvancedMessage
{
    /** @var \SumanIon\TelegramBot\Manager */
    protected $manager;

    /** @var mixed */
    protected $user;

    /** @var string */
    protected $text = '';

    /** @var array */
    protected $options = [];

    /** @var array */
    protected $inlineButtons = [];

    /** @var int */
    protected $inlineButtonsRow = 0;

    /** @var array */
    protected $keyboardButtons = [ 'keyboard' => [] ];

    /** @var int */
    protected $keyboardButtonsRow = 0;

    /** @var array */
    protected $forceReply = [];

    /**
     * Creates a new advanced message.
     *
     * @param \SumanIon\TelegramBot\Manager $manager
     * @param mixed                         $user
     */
    public function __construct(Manager $manager, $user)
    {
        $this->manager = $manager;
        $this->user    = $user;
    }

    /**
     * Adds a text to the message.
     *
     * @param  string $text
     *
     * @return static
     */
    public function text(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Changes parse mode of the message to default.
     *
     * @return static
     */
    public function raw()
    {
        unset($this->options['parse_mode']);

        return $this;
    }

    /**
     * Changes parse mode of the message to Markdown.
     *
     * @return static
     */
    public function markdown()
    {
        $this->options['parse_mode'] = 'Markdown';

        return $this;
    }

    /**
     * Changes parse mode of the message to HTML.
     *
     * @return static
     */
    public function html()
    {
        $this->options['parse_mode'] = 'HTML';

        return $this;
    }

    /**
     * Disables web pages preview for the message.
     *
     * @return static
     */
    public function disableWebPagePreview()
    {
        $this->options['disable_web_page_preview'] = true;

        return $this;
    }

    /**
     * Alias to disable web pages preview for the message.
     *
     * @return static
     */
    public function withoutPreview()
    {
        return $this->disableWebPagePreview();
    }

    /**
     * Sends the message silently.
     *
     * @return static
     */
    public function disableNotification()
    {
        $this->options['disable_notification'] = true;

        return $this;
    }

    /**
     * Alias to send message silently.
     *
     * @return static
     */
    public function silent()
    {
        return $this->disableNotification();
    }

    /**
     * Sets the original message id if the current message is a reply.
     *
     * @param  int    $message_id
     *
     * @return static
     */
    public function replyTo(int $message_id)
    {
        $this->options['reply_to_message_id'] = $message_id;

        return $this;
    }

    /**
     * Adds a new inline keyboard button to the message.
     *
     * @param  string $text
     * @param  string $type
     * @param  string $value
     *
     * @return static
     */
    protected function inlineButton(string $text, string $type, string $value)
    {
        $button = [ 'text' => $text, $type => $value ];

        if (!isset($this->inlineButtons[$this->inlineButtonsRow])) {

            $this->inlineButtons[$this->inlineButtonsRow] = [];
        }

        $this->inlineButtons[$this->inlineButtonsRow][] = $button;

        return $this;
    }

    /**
     * Adds a new url button to the message.
     *
     * @param  string $text
     * @param  string $url
     *
     * @return static
     */
    public function button(string $text, string $url)
    {
        return $this->inlineButton($text, 'url', $url);
    }

    /**
     * Adds a new callback button to the message.
     *
     * @param  string $text
     * @param  string $callback_data
     *
     * @return static
     */
    public function callbackButton(string $text, string $callback_data)
    {
        return $this->inlineButton($text, 'callback_data', $callback_data);
    }

    /**
     * Adds a new switch button to the message.
     *
     * @param  string $text
     * @param  string $switch_inline_query
     *
     * @return static
     */
    public function switchButton(string $text, string $switch_inline_query)
    {
        return $this->inlineButton($text, 'switch_inline_query', $switch_inline_query);
    }

    /**
     * Adds a new switch to current chat button to the message.
     *
     * @param  string $text
     * @param  string $switch_inline_query_current_chat
     *
     * @return static
     */
    public function switchToChatButton(string $text, string $switch_inline_query_current_chat)
    {
        return $this->inlineButton($text, 'switch_inline_query_current_chat', $switch_inline_query_current_chat);
    }

    /**
     * Creates a new row for new inline keyboard buttons.
     *
     * @return static
     */
    public function nextRow()
    {
        $this->inlineButtonsRow += 1;

        return $this;
    }

    /**
     * Adds a new keyboard button to the message.
     *
     * @param  string $text
     * @param  bool   $request_contact
     * @param  bool   $request_location
     *
     * @return static
     */
    public function keyboardButton(string $text, bool $request_contact = false, bool $request_location = false)
    {
        $button = [ 'text' => $text, 'request_contact' => $request_contact, 'request_location' => $request_location ];

        if (!isset($this->keyboardButtons['keyboard'][$this->keyboardButtonsRow])) {

            $this->keyboardButtons['keyboard'][$this->keyboardButtonsRow] = [];
        }

        $this->keyboardButtons['keyboard'][$this->keyboardButtonsRow][] = $button;

        return $this;
    }

    /**
     * Creates a new row for new keyboard buttons.
     *
     * @return static
     */
    public function nextKeyboardRow()
    {
        $this->keyboardButtonsRow += 1;

        return $this;
    }

    /**
     * Resizes the keyboard vertically for optimal fit.
     *
     * @return static
     */
    public function resizeKeyboard()
    {
        $this->keyboardButtons['resize_keyboard'] = true;

        return $this;
    }

    /**
     * Hides the keyboard as soon as it is used.
     *
     * @return static
     */
    public function oneTimeKeyboard()
    {
        $this->keyboardButtons['one_time_keyboard'] = true;

        return $this;
    }

    /**
     * Makes the keyboard selective.
     *
     * @return static
     */
    public function selectiveKeyboard()
    {
        $this->keyboardButtons['selective'] = true;

        return $this;
    }

    /**
     * Removes the custom keyboard.
     *
     * @param  bool   $selective
     *
     * @return static
     */
    public function removeKeyboard(bool $selective = false)
    {
        $this->keyboardButtons = [ 'remove_keyboard' => true, 'selective' => $selective ];

        return $this;
    }

    /**
     * Forces the user to reply to the message.
     *
     * @param  bool   $selective
     *
     * @return static
     */
    public function forceReply(bool $selective = false)
    {
        $this->forceReply = [ 'force_reply' => true, 'selective' => $selective ];

        return $this;
    }

    /**
     * Sends the advanced message to the user.
     *
     * @return void
     */
    public function send()
    {
        $this->options['reply_markup'] = isset($this->options['reply_markup']) ? (array)$this->options['reply_markup'] : [];

        if (!empty($this->inlineButtons)) {
            $this->options['reply_markup']['inline_keyboard'] = $this->inlineButtons;
        }

        if (!empty($this->keyboardButtons)) {
            $this->options['reply_markup'] = array_merge($this->options['reply_markup'], $this->keyboardButtons);
        }

        if (!empty($this->forceReply)) {
            $this->options['reply_markup'] = array_merge($this->options['reply_markup'], $this->forceReply);
        }

        $this->options['reply_markup'] = json_encode($this->options['reply_markup']);

        $this->manager->sendMessage($this->user, $this->text, $this->options);
    }
}