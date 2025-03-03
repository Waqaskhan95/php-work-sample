<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function video() {
        return $this->belongsTo(Video::class);
    }

    public function replies() {
        return $this->hasMany(Comment::class);
    }

    public function getRepliesCountAttribute() {
       return $this->replies()->count();
    }
}
