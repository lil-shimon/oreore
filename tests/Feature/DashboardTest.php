<?php

use App\Models\Exchange;
use App\Models\User;
use App\Services\Exchanges\MexcClient;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    Exchange::factory()->create(['name' => 'MEXC']);

    $this->mock(MexcClient::class, function ($mock) {
        $mock->shouldReceive('getBalances')->andReturn([]);
        $mock->shouldReceive('getTickerPrices')->andReturn([]);
    });

    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});
