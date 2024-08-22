<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class State extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function getStateByCountry(Request $request) {
        $states = $this;

        $states = $states->where('country_id',$request->country_id);

        $states = $states->get();
        return $states;     
    }
}
