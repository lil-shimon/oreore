<?php

namespace App\Contracts;

interface ExchangeClientInterface
{
    public function getBalances(): array;
}
