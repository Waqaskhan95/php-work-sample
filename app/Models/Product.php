<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function images() {
        return $this->morphMany(Image::class,'imageable');
    }

    public function variations() {
        return $this->hasMany(ProductVariation::class);
    }

    public function ratings() {
        return $this->hasMany(ProductRating::class);
    }

    public function isFav() {
        if (auth()->user()) {
            $check = Wishlist::where('user_id',auth()->user()->id)->where('product_id',$this->id)->first();
            if ($check) {
                return true;
            }
        }
        return false;
    }
}
