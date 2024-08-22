<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ModelHasRole extends Model
{
    use HasFactory;
    protected $table = 'model_has_roles';

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'model_id');
    }

    // Define the relationship with the Role model
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
