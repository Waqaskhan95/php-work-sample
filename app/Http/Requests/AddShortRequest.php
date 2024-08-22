<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddShortRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required',
            'description'   => 'required',
            'country_id'    => 'required',
            'state_id'      => 'required',
            'city_id'       => 'required',
            'short'         => 'required|file',
            'thumbnail'     => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ];
    }
}
