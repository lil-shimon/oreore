<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Token;
use App\Models\WalletRecord;
use App\Services\Exchanges\MexcClient;
use Illuminate\Support\Facades\DB;
use Inertia\Response;

class WalletController extends Controller
{
    public function __construct(
        private MexcClient $mexcClient
    ) {}

    public function index(): Response
    {
        $balances = $this->mexcClient->getBalances();

        $today = today();
        $exchange = Exchange::where('name', 'MEXC')->firstOrFail();
        $exists = WalletRecord::where('exchange_id', $exchange->id)->whereDate('created_at', $today)->exists();

        if (! $exists) {
            DB::transaction(function () use ($exchange, $balances) {

                $record = WalletRecord::create(['exchange_id' => $exchange->id]);
                foreach ($balances as $balance) {
                    $token = Token::where('symbol', $balance['asset'])->first();

                    // TODO: create token
                    if (! $token) {
                        continue;
                    }

                    $record->walletTokens()->create([
                        'token_id' => $token->id,
                        'available' => $balance['free'],
                        'locked' => $balance['locked'],
                    ]);
                }
            });
        }

        return inertia('dashboard', [
            'balances' => $balances,
        ]);
    }
}
