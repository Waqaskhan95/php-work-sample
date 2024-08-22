<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const ADMIN = 1;
    const FAN = 2;
    const ATHELETE = 3;
    const COSTACASTER = 4;
    const GUEST = 5;
}
