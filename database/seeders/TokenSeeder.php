<?php

namespace Database\Seeders;

use App\Models\Token;
use Illuminate\Database\Seeder;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 持っているトークンを最低限シードデータに追加
        // ウォレット接続時にTokenがデータにない場合はデータを作成する
        Token::firstOrCreate(['name' => 'Bitcoin', 'symbol' => 'BTC']);
        Token::firstOrCreate(['name' => 'Ethereum', 'symbol' => 'ETH']);
        Token::firstOrCreate(['name' => 'Tether', 'symbol' => 'USDT']);
        Token::firstOrCreate(['name' => 'USD Coin', 'symbol' => 'USDC']);
        Token::firstOrCreate(['name' => 'Pepe', 'symbol' => 'PEPE']);
        Token::firstOrCreate(['name' => 'Cardano', 'symbol' => 'ADA']);
        Token::firstOrCreate(['name' => 'Terra', 'symbol' => 'LUNA']);
        Token::firstOrCreate(['name' => 'Solana', 'symbol' => 'SOL']);
        Token::firstOrCreate(['name' => 'XRP', 'symbol' => 'XRP']);
        Token::firstOrCreate(['name' => 'Polkadot', 'symbol' => 'DOT']);
        Token::firstOrCreate(['name' => 'DOGE', 'symbol' => 'DOGE']);
        Token::firstOrCreate(['name' => 'SHIBAINU', 'symbol' => 'SHIB']);
        Token::firstOrCreate(['name' => 'pump.fun', 'symbol' => 'PUMP']);
        Token::firstOrCreate(['name' => 'SUI', 'symbol' => 'SUI']);
        Token::firstOrCreate(['name' => 'Pudgy Penguins', 'symbol' => 'PENGU']);
    }
}
