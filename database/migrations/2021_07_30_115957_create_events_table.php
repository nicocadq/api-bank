<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations. TODO: delete `unsigned` and `nullable` methods from schema
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['deposito', 'retiro', 'transferencia']);
            $table->float('amount');
            $table->unsignedBigInteger('origin_wallet_id')->unsigned()->nullable();
            $table->foreign('origin_wallet_id')->references('id')->on('wallets');
            $table->unsignedBigInteger('destiny_wallet_id')->unsigned()->nullable();
            $table->foreign('destiny_wallet_id')->references('id')->on('wallets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
