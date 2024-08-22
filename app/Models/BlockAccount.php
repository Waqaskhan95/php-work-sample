<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function fromUser() {
        return $this->belongsTo(User::class,'from_user');
    }

    public function toUser() {
        return $this->belongsTo(User::class,'to_user');
    }
}
