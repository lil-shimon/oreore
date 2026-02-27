<?php

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
