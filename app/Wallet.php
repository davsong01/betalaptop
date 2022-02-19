<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id', 'type', 'amount', 'recipient_id'
    ];

    /**
     * Get the wallet owner
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     *  Get the recipient of the wallet
     */
    public function transferRecipient(){
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
