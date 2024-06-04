<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'card_number',
        'cvv_number',
        'expiry_date',
        'balance',
        'currency',
        'banking_product',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'card_number',
        'cvv_number',
        'expiry_date',
    ];

    public function accounts()
    {
        return $this->belongsTo(User::class);
    }
}