<?php

namespace App\Http\Controllers;

use App\Services\Exchanges\MexcClient;

class WalletController extends Controller
{
    public function __construct(
        private MexcClient $mexcClient
    ) {}

    public function index()
    {
        $data = $this->mexcClient->getBalances();

        return inertia('wallet/index', [
            'balances' => $data,
        ]);
    }
}
