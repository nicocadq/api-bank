<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function index($id){
        $wallet = Wallet::findOrFail($id);

        return response()->json(['id' => $wallet->id, 'balance' => $wallet->money], 200);
    }
}
