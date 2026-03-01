<?php

namespace App\Http\Controllers;

use App\Actions\FetchWalletBalancesAction;
use App\Models\Exchange;
use App\Models\WalletRecord;
use Inertia\Response;

class WalletController extends Controller
{
    public function __construct(
        private FetchWalletBalancesAction $action
    ) {}

    public function index(): Response
    {
        $exchange = Exchange::where('name', 'MEXC')->firstOrFail();
        $yesterday = today()->subDay();

        $record = $this->action->execute($exchange);
        $record->load('walletTokens.token');

        $balances = $record->walletTokens->map(fn ($wt) => [
            'asset' => $wt->token->symbol,
            'available' => $wt->available,
            'locked' => $wt->locked,
            'usdt_value' => (float) $wt->usdt_value,
        ]);

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
