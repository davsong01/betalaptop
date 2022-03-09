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
}
