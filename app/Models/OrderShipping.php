<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function order() {
        return $this->belongsTo(Order::class);
    }
    
    public function country() {
        return $this->belongsTo(Country::class);
    }
    
    public function city() {
        return $this->belongsTo(City::class);
    }
    
    public function state() {
        return $this->belongsTo(State::class);
    }

    
}
