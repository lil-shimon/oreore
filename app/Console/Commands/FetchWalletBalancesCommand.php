<?php

namespace App\Console\Commands;

use App\Actions\FetchWalletBalancesAction;
use App\Models\Exchange;
use Illuminate\Console\Command;

class FetchWalletBalancesCommand extends Command
{
    protected $signature = 'wallet:fetch';

    protected $description = 'Fetch and store wallet balances from MEXC';

    public function __construct(private FetchWalletBalancesAction $action)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $exchange = Exchange::where('name', 'MEXC')->first();

        if (! $exchange) {
            $this->error('MEXC exchange not found.');

            return self::FAILURE;
        }

        $record = $this->action->execute($exchange);

        $this->info("Wallet record saved. ID: {$record->id}");

        return self::SUCCESS;
    }
}
