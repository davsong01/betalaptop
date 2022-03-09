<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProofOfPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'path', 'status', 'amount'
    ];

    /**
     * Get the proof of payment owner
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
