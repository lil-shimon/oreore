<?php

namespace Database\Seeders;

use App\Models\Exchange;
use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exchange::firstOrCreate(['name' => 'KuCoin']);
        Exchange::firstOrCreate(['name' => 'MEXC']);
        Exchange::firstOrCreate(['name' => 'Binance']);
        Exchange::firstOrCreate(['name' => 'Coinbase']);
        Exchange::firstOrCreate(['name' => 'Bybit']);
        Exchange::firstOrCreate(['name' => 'Kraken']);
        Exchange::firstOrCreate(['name' => 'bitFlyer']);
        Exchange::firstOrCreate(['name' => 'CoinW']);
        Exchange::firstOrCreate(['name' => 'Zaif']);
        Exchange::firstOrCreate(['name' => 'Bitrue']);
        Exchange::firstOrCreate(['name' => 'GMO']);
    }
}
