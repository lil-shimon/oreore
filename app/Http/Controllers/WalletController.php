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
        $yesterday = today()->subDay();

        $prices = collect($this->mexcClient->getTickerPrices())->keyBy('symbol');

        $record = WalletRecord::where('exchange_id', $exchange->id)
            ->whereDate('created_at', $today)
            ->with('walletTokens.token')
            ->first();

        if ($record) {
            $balances = $record->walletTokens->map(fn ($wt) => [
                'asset' => $wt->token->symbol,
                'available' => $wt->available,
                'locked' => $wt->locked,
                'usdt_value' => (float) $wt->usdt_value,
            ]);
        } else {
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

            DB::transaction(function () use ($exchange, $balances) {
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
        }

        $yesterdayRecord = WalletRecord::where('exchange_id', $exchange->id)
            ->whereDate('created_at', $yesterday)
            ->with('walletTokens.token')
            ->first();

        $yesterdayValues = $yesterdayRecord
            ? $yesterdayRecord->walletTokens->keyBy(fn ($wt) => $wt->token->symbol)
            : collect();

        $balances = $balances->map(function ($b) use ($yesterdayValues) {
            $asset = $b['asset'];
            $prevValue = (float) ($yesterdayValues->get($asset)?->usdt_value ?? 0);
            $diff = $b['usdt_value'] - $prevValue;
            $diffPct = $prevValue > 0 ? ($diff / $prevValue) * 100 : null;

            return [
                ...$b,
                'usdt_value_prev' => $prevValue,
                'usdt_value_diff' => $diff,
                'usdt_value_diff_pct' => $diffPct,
            ];
        });

        return inertia('dashboard', [
            'balances' => $balances,
        ]);
    }
}
