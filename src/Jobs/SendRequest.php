<?php

namespace SumanIon\TelegramBot\Jobs;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRequest implements ShouldQueue
{
    /** @var string */
    protected $url;

    /** @var string */
    protected $type;

    /** @var array */
    protected $fields;

    /**
     * Creates a new job instance.
     *
     * @param string $type
     * @param string $url
     * @param array  $fields
     */
    public function __construct(string $type, string $url, array $fields = [])
    {
        $this->type    = $type;
        $this->url     = $url;
        $this->fields  = $fields;
    }

    /**
     * Executes the job.
     *
     * @return void
     */
    public function handle()
    {
        if (isset($this->fields['multipart'])) {

            $this->fields['multipart'] = (new Collection((array)$this->fields['multipart']))->map(function ($field) {

                $field['contents'] = fopen($field['contents'], 'r');

                return $field;
            })->all();
        }

        $response = (new Client( [ 'http_errors' => false ]))->request($this->type, $this->url, $this->fields);
        $response = (string)$response->getBody();

        Log::info("[{$this->type} {$this->url}] => {$response}");
    }
}
