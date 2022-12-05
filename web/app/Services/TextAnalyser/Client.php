<?php

namespace App\Services\TextAnalyser;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    protected static $baseUri = 'http://127.0.0.1:5000';

    public function make(array $config = []): mixed
    {
        // code...
    }

    public function makeRequest(array $data = []): Response
    {
        return Http::post(static::$baseUri, $data);
    }

    public function evaluate(string $text): string
    {
        $response = $this->makeRequest(['body' => $text])->json();

        if (is_null($response)) {
            return '';
        }

        return $response;
    }
}
