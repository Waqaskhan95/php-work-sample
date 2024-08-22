<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class City extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getCityByState(Request $request) {
        $cities = $this;

        $cities = $cities->where('state_id',$request->state_id);

        $cities = $cities->get();
        return $cities;
    }

}
