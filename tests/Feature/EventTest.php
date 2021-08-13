<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Wallet;

class EventTest extends TestCase
{
    
    public function testCreateDeposit()
    {
        $amount = 100;
        $wallet = Wallet::factory()->create();

        $response = $this->post('/api/evento', ['tipo' => 'deposito', 'destino' => $wallet->id, 'monto' => $amount]);

        $response
        ->assertStatus(200)
        ->assertJson([
            'id' => $wallet->id,
            'balance' => ($wallet->money + $amount)
        ]);
    }

    public function testCreateWithdrawal()
    {
        $amount = 100;
        $wallet = Wallet::factory()->create();

        $response = $this->post('/api/evento', ['tipo' => 'retiro', 'origen' => $wallet->id, 'monto' => $amount]);

        $response
        ->assertStatus(200)
        ->assertJson([
            'id' => $wallet->id,
            'balance' => ($wallet->money - $amount)
        ]);
    }

    public function testCreateTransfer()
    {
        $amount = 100;
        $origin_wallet = Wallet::factory()->create();
        $destiny_wallet = Wallet::factory()->create();

        $response = $this->post('/api/evento', 
            ['tipo' => 'transferencia', 'origen' => $origin_wallet->id, 'destino' => $destiny_wallet->id, 'monto' => $amount]
        );

        $response
        ->assertStatus(200)
        ->assertJson([
            [ 'id' => $origin_wallet->id, 'balance' => ($origin_wallet->money - $amount)],
            [ 'id' => $destiny_wallet->id, 'balance' => ($destiny_wallet->money + $amount)],
        ]);
    }


    public function testCreateWithdrawalNotEnoughMoney()
    {
        $wallet = Wallet::factory()->create();
        $biggerAmount = 1000;

        $response = $this->post('/api/evento', ['tipo' => 'retiro', 'origen' => $wallet->id, 'monto' => $biggerAmount]);

        $response
        ->assertStatus(400)
        ->assertJson([
            'error' => 'Not enough money to make the withdrawal',
        ]);
    }
}
