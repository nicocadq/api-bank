<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\EventController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/balance/{id}', [WalletController::class, 'index']);
Route::put('/balance/{id}', [WalletController::class, 'update']);
Route::post('/balance', [WalletController::class, 'create']);
Route::post('/evento', [EventController::class, 'create']);


Route::post('/reset', function() {
  return Artisan::call('migrate:fresh');    
});