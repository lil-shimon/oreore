<?php

namespace App\Services\Exchanges;

use App\Contracts\ExchangeClientInterface;

class MexcClient implements ExchangeClientInterface
{
    public function __construct(
        private string $apiKey,
        private string $apiSecret,
    ){}

    public function getBalances(): array
    {
        return [];
    }
}
