<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'email'
    ];

    protected $attributes = [
        'money' => 0,
    ];

    public function events(){
        return $this->hasMany(Event::class);
    }
}
