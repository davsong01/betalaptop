<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'type', 'transaction_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
