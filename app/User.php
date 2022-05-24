<?php

namespace App;

use App\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Traits\FunctionsTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use  \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable, FunctionsTrait;
    // use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'children' => 'array',
    ];

    public function wallet(){
        return $this->getWallet($this->id);
    }

    public function level(){
        return $this->getLevel($this->id);
    }

    public static function downline($id){
        $user = User::find($id);
        return $user;
    }
    
    /**
     * Get the user upline User
     *
     * @return BelongsTo
     */
    public function nextUpline(): BelongsTo
    {
        return $this->belongsTo(User::class, 'upline');
    }

    /**
     * Get the user matrices
     *
     * @return HasMany
     */
    public function matrices(): HasMany
    {
        return $this->hasMany(Matrix::class);
    }
}
