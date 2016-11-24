<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedContactMessage extends AdvancedMessage
{
    /** @var string */
    protected $phoneNumber = '';

    /** @var string */
    protected $firstName = '';

    /** @var string */
    protected $lastName = '';

    /**
     * Adds the phone number to the contact.
     *
     * @param  string $phone_number
     *
     * @return static
     */
    public function phoneNumber(string $phone_number)
    {
        $this->phoneNumber = $phone_number;

        return $this;
    }

    /**
     * Adds the first name to the contact.
     *
     * @param  string $first_name
     *
     * @return static
     */
    public function firstName(string $first_name)
    {
        $this->firstName = $first_name;

        return $this;
    }

    /**
     * Adds the last name to the contact.
     *
     * @param  string $last_name
     *
     * @return static
     */
    public function lastName(string $last_name)
    {
        $this->lastName = $last_name;

        return $this;
    }

    /**
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendContact($this->chat, $this->phoneNumber, $this->firstName, $this->lastName, $this->options);
    }
}