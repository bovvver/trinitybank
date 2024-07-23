<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'input_amount',
        'amount',
        'currency',
        'category',
        'dispatch_date',
    ];

    public function sender()
    {
        return $this->belongsTo(Account::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Account::class, 'receiver_id');
    }
}
