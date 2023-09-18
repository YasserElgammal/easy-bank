<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function senderUser()
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    public function receiverUser()
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }
}
