<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function senderCustomer()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    public function receiverCustomer()
    {
        return $this->hasMany(Transaction::class, 'receiver_id');
    }

    public function scopeDecrementBalance($query, $amount)
    {
        return $query->where('user_id', auth()->id())->decrement('balance', $amount);
    }

    public function scopeIncrementBalance($query, $receiverId ,$amount)
    {
        return $query->where('id', $receiverId)->increment('balance', $amount);
    }
}
