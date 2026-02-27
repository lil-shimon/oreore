<?php

namespace App\Http\Controllers;

use App\Services\Exchanges\MexcClient;
use Inertia\Response;

class WalletController extends Controller
{
    public function __construct(
        private MexcClient $mexcClient
    ) {}

    public function index(): Response
    {
        $data = $this->mexcClient->getBalances();

        return inertia('dashboard', [
            'balances' => $data,
        ]);
    }
}
