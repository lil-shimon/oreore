<?php

namespace App\Actions;

use App\Models\Exchange;
use App\Models\Token;
use App\Models\WalletRecord;
use App\Services\Exchanges\MexcClient;
use Illuminate\Support\Facades\DB;

class FetchWalletBalancesAction
{
    public function __construct(private MexcClient $mexcClient) {}

    public function execute(Exchange $exchange): WalletRecord
    {
        $existing = WalletRecord::where('exchange_id', $exchange->id)
            ->whereDate('created_at', today())
            ->first();

        if ($existing) {
            return $existing;
        }

        $prices = collect($this->mexcClient->getTickerPrices())->keyBy('symbol');

        $balances = collect($this->mexcClient->getBalances())->map(function ($b) use ($prices) {
            $asset = $b['asset'];
            $price = $asset === 'USDT' ? 1.0 : (float) ($prices->get($asset.'USDT')['price'] ?? 0);

            return [
                'asset' => $asset,
                'available' => $b['free'],
                'locked' => $b['locked'],
                'usdt_value' => $price * (float) $b['free'],
            ];
        });

        $record = null;

        DB::transaction(function () use ($exchange, $balances, &$record) {
            $record = WalletRecord::create(['exchange_id' => $exchange->id]);

            foreach ($balances as $balance) {
                $token = Token::where('symbol', $balance['asset'])->first();

                if (! $token) {
                    continue;
                }

                $record->walletTokens()->create([
                    'token_id' => $token->id,
                    'available' => $balance['available'],
                    'locked' => $balance['locked'],
                    'usdt_value' => $balance['usdt_value'],
                ]);
            }
        });

        return $record;
    }
}
