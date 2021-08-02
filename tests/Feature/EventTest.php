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
        ->assertStatus(201)
        ->assertJson([
            'id' => $wallet->id,
            'balance' => ($wallet->money + $amount)
        ]);
    }
}
