<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;

class Event extends Model
{
    use HasFactory;

    public function origin()
    {
        return $this->belongsTo(Wallet::class, 'origin_wallet_id');
    }

    public function destiny()
    {
        return $this->belongsTo(Wallet::class, 'destiny_wallet_id');
    }
}
