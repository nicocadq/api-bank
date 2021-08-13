<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Event;

class EventController extends Controller
{

    private $DEPOSIT = 'deposito';
    private $WITHDRAWAL = 'retiro';
    private $TRANSFER = 'transferencia';

    public function create(Request $request){
        $type = $request->input('tipo');

        switch ($type) {
            case $this->DEPOSIT:
                $wallet = Wallet::findOrFail($request->input('destino'));
                
                $wallet->money = $wallet->money + $request->input('monto');
                $wallet->save();

                return response()->json(['id' => $wallet->id, 'balance' => $wallet->money], 200);
            case $this->WITHDRAWAL:
                $wallet = Wallet::findOrFail($request->input('origen'));

                if($wallet->money < $request->input('monto')){
                    return response()->json(['error' => 'Not enough money to make the withdrawal'], 400);
                }

                $wallet->money = $wallet->money - $request->input('monto');
                $wallet->save();

                return response()->json(['id' => $wallet->id, 'balance' => $wallet->money], 200);
            case $this->TRANSFER:
                $origin_wallet = Wallet::findOrFail($request->input('origen'));
                $destiny_wallet = Wallet::findOrFail($request->input('destino'));

                if($origin_wallet->money < $request->input('monto')){
                    return response()->json(['error' => 'The origin wallet does not have enough money'], 400);
                }

                $origin_wallet->money = $origin_wallet->money - $request->input('monto');
                $origin_wallet->save();

                $destiny_wallet->money = $destiny_wallet->money + $request->input('monto');
                $destiny_wallet->save();

                return response()->json([
                    ['id' => $origin_wallet->id, 'balance' => $origin_wallet->money], 
                    ['id' => $destiny_wallet->id, 'balance' => $destiny_wallet->money]
                ], 200);            
            default:
                return response()->json(['error' => 'Not found'], 404);
          }
    }
}
