<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Wallet;

class WalletTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetWallet()
    {
        $wallet = Wallet::factory()->create();

        $response = $this->get('/api/balance/1');

        $response->assertStatus(200)->assertJsonStructure([
            'id', 'balance'
        ]);
    }
}
