<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Event;
use App\Models\Token;
use Illuminate\Support\Facades\Mail;

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

                $event = Event::create([
                    'type' => $request->input('tipo'),
                    'amount' => $request->input('monto'),
                    'destiny_wallet_id' => $wallet->id
                ]);

                $wallet->money = $wallet->money + $request->input('monto');
                $wallet->save();

                return response()->json(['id' => $wallet->id, 'balance' => $wallet->money], 200);
            case $this->WITHDRAWAL:
                $wallet = Wallet::findOrFail($request->input('origen'));

                $event = Event::create([
                    'type' => $request->input('tipo'),
                    'amount' => $request->input('monto'),
                    'origin_wallet_id' => $wallet->id
                ]);

                $maxAmount = 10;

                if($wallet->money < $request->input('monto')){
                    return response()->json(['error' => 'Dinero insuficiente para realizar el retiro'], 400);
                }

                $is_valid_token = $this->isValidToken($request);

                if($request->input('monto') >= $maxAmount && !($is_valid_token)){
                    $token = Token::create([
                        'event' => $event->id
                    ]);;

                    $data_to_mailer = [
                        'wallet' => $wallet,
                        'token' => $token->id
                    ];

                    Mail::to($wallet->email)->send(new \App\Mail\BigWithdrawalToken($data_to_mailer));

                    return response()->json([
                        'error' => 'Cantidad permitida excedida, enviamos un token a su email para realizar el retiro'
                    ], 400);
                } else {
                    $wallet->money = $wallet->money - $request->input('monto');
                    $wallet->save();
                    return response()->json(['id' => $wallet->id, 'balance' => $wallet->money], 200);
                }
            case $this->TRANSFER:
                $origin_wallet = Wallet::findOrFail($request->input('origen'));
                $destiny_wallet = Wallet::findOrFail($request->input('destino'));

                $event = Event::create([
                    'type' => $request->input('tipo'),
                    'amount' => $request->input('monto'),
                    'origin_wallet_id' => $origin_wallet->id,
                    'destiny_wallet_id' => $destiny_wallet->id
                ]);

                if($origin_wallet->money < $request->input('monto')){
                    return response()->json(['error' => 'La cartera no tiene dinero suficiente'], 400);
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

    protected function isValidToken(Request $request){
        $date = new \DateTime();
        $date_to_compare = $date->modify('-5 minutes');

        $token = Token::where('id', $request->input('token'))->whereDate('created_at', '>=', $date_to_compare)->first();

        if($token) return true;

        return false;
    }
}
