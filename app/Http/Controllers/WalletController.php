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
        $exchange = Exchange::where('name', 'MEXC')->firstOrFail();
        $today = today();
        $record = WalletRecord::where('exchange_id', $exchange->id)->whereDate('created_at', $today)->with('walletTokens.token')->first();

        if ($record) {
            $balances = $record->walletTokens->map(fn ($wt) => [
                'asset' => $wt->token->symbol,
                // dupulicated
                'free' => $wt->available,
                'locked' => $wt->locked,
                'available' => $wt->available,
            ]);
        } else {

            $balances = collect($this->mexcClient->getBalances());

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

        $prices = collect($this->mexcClient->getTickerPrices())->keyBy('symbol');

        $balances = $balances->map(function ($b) use ($prices) {
            $asset = $b['asset'];
            $price = $asset === 'USDT' ? 1.0 : (float) ($prices->get($asset.'USDT')['price'] ?? 0);

            return [...$b, 'usdt_value' => (float) $price * $asset];
        });

        return inertia('dashboard', [
            'balances' => $balances,
        ]);
    }
}
