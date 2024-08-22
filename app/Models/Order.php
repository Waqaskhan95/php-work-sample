<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);    
    }

    public function details(){
        return $this->hasMany(OrderDetail::class);
    }

    public function payment(){
        return $this->hasOne(OrderPayment::class);
    }

    public function shipping() {
        return $this->hasOne(OrderShipping::class);
    }
}
