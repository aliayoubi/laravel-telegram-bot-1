<?php

namespace SumanIon\TelegramBot\Methods;

class AdvancedDocumentMessage extends AdvancedMessage
{
    /** @var string */
    protected $document = '';

    /** @var string */
    protected $caption = '';

    /**
     * Adds a document to the advanced message.
     *
     * @param  string $document
     *
     * @return static
     */
    public function document(string $document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Sets the caption of the document.
     *
     * @param  string $caption
     *
     * @return static
     */
    public function caption(string $caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Sends the request.
     *
     * @return void
     */
    protected function handle()
    {
        $this->manager->sendDocument($this->user, $this->document, $this->caption, $this->options);
    }
}