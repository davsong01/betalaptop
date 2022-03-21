<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matrix extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'left',
        'right'
    ];

    /**
     * Get the matrices owner
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
