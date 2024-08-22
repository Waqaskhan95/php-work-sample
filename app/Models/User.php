<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Billable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function activeSubscription() {
        return $this->hasOne(Subscription::class)->where('end_at','>',now()->toDateString());
    }

    public function manySubscriptions() {
        return $this->hasMany(Subscription::class);
    }

    public function follower() {
        return $this->hasMany(RoleFollow::class);
    }
    public function team() {
        return $this->hasOne(UserTeam::class);
    }

    public function followers() {
        return $this->hasMany(UserFollower::class);
    }

    public function followings() {
        return $this->hasMany(UserFollower::class,'from_user');
    }

    public function videos() {
        return $this->hasMany(Video::class);
    }
}
