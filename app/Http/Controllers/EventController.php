<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

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

                return response()->json(['id' => $wallet->id, 'balance' => $wallet->money], 201);
            default:
             return response()->json('Not found', 404);
          }
    }
}
