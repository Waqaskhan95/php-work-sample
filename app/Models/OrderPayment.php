<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function payment() {
        return $this->belongsTo(PaymentLog::class,'payment_id');
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }

}
