<?php

namespace SumanIon\TelegramBot\Features;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use SumanIon\TelegramBot\ParsedUpdate;

trait SendsApiRequests
{
    /**
     * Returns full Api url.
     *
     * @param  string $method
     * @param  array  $query
     *
     * @return string
     */
    public function url(string $method = '', array $query = []):string
    {
        return "https://api.telegram.org/bot{$this->token()}/{$method}" . (!empty($query) ? '?' . http_build_query($query) : '');
    }

    /**
     * Returns full url to a file.
     *
     * @param  string $file_path
     *
     * @return string
     */
    public function fileUrl(string $file_path):string
    {
        return "https://api.telegram.org/file/bot{$this->token()}/{$file_path}";
    }

    /**
     * Sends an Api request to the Bot.
     *
     * @param  string $type
     * @param  string $method
     * @param  array  $query
     * @param  array  $fields
     *
     * @return array
     */
    public function sendRequest(string $type, string $method, array $query = [], array $fields = []):array
    {
        return $this->parseResponse(
            (new Client([ 'http_errors' => false ]))->request($type, $this->url($method, $query), $fields),
            $this->url($method, $query)
        );
    }

    /**
     * Parses Api request responses.
     *
     * @param  \GuzzleHttp\Psr7\Response $response
     * @param  string                    $url
     *
     * @return array
     */
    public function parseResponse(Response $response, string $url):array
    {
        $parsed = json_decode((string)$response->getBody());

        if (!is_object($parsed) or !isset($parsed->ok) or $parsed->ok !== true) {

            Log::error('[' . get_class($this) . '] in [' . $url . '] => ' . (string)$response->getBody());

            return [];
        }

        return (new Collection(is_object($parsed->result) ? [ $parsed->result ] : $parsed->result))->map(function ($update) {
            return new ParsedUpdate(json_encode($update));
        })->all();
    }
}