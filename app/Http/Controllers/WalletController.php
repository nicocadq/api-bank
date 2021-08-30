<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends ApiController
{
    public function index($id){
        try {
            $wallet = Wallet::findOrFail($id);

            return response()->json(['id' => $wallet->id, 'balance' => $wallet->money, 'email' => $wallet->email]);
        } catch (Exception $exception){
            return  $this->sendError('Cartera no encontrada');
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
            return  response()->json(['error' => 'Este email ya existe'], 404);
        }
      
    }

    // public function update(Request $request, $id)
    // {
    //     $donation = Donation::find($id);
    //     $donation->update($request->all());
    //     return $donation;
    // }

    public function update(Request $request, $id){
        try{
            $wallet = Wallet::find($id);
            $old_email = $wallet->email;
            $wallet->update($request->all());

            return response()->json(['current_email' => $wallet->email, 'old_email' => $old_email], 200);
        } catch(\Exception $exception){
            return  response()->json(['error' => 'Cuenta no encontrada'], 404);
        }
    }
}
