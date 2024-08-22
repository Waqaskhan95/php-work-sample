<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function color() {
        return $this->belongsTo(ProductColor::class);
    }

    public function size() {
        return $this->belongsTo(ProductSize::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
