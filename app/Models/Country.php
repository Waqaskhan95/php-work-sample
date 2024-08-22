<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Country extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    
    public function getAllCountries(Request $request) {
       $countries = $this;
       $countries = $countries->get();

       return $countries;
    }
}
