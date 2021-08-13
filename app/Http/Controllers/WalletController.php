<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends ApiController
{
    public function index($id){
        try {
            $wallet = Wallet::findOrFail($id);

            return response()->json(['id' => $wallet->id, 'balance' => $wallet->money]);
        } catch (Exception $exception){
            return  $this->sendError('Wallet not found');
        }
      
    }

    public function create(Request $request){
        try {
            $wallet = Wallet::create([
                'email' => $request->input('email')
            ]);

            return response()->json([
                'id' => $wallet->id, 
                'balance' => $wallet->money,
                'email' => $wallet->email
            ], 201);
        } catch (\Exception $exception){
            return  $this->sendError('Wallet was not created');
        }
      
    }
}
