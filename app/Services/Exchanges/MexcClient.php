<?php

namespace App\Services\Exchanges;

use App\Contracts\ExchangeClientInterface;
use Illuminate\Support\Facades\Http;

class MexcClient implements ExchangeClientInterface
{
    public function __construct(
        private string $apiKey,
        private string $apiSecret,
    ){}

    public function getBalances(): array
    {
        $timestamp = now()->timestamp * 1000;
        $query = 'timestamp=' . $timestamp;
        $signature = hash_hmac('sha256', $query, $this->apiSecret);
        $response = Http::withHeader('X-MEXC-APIKEY', $this->apiKey)->get('https://api.mexc.com/api/v3/account', [
            'timestamp' => $timestamp,
            'signature' => $signature,
        ]);

        return $response->json(['balance', []]);
    }
}
