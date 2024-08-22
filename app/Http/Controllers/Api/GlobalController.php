<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Plan;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Http\Requests\GetStateByCountryRequest;
use App\Http\Requests\GetCityByStateRequest;

class GlobalController extends Controller
{
    protected $categories;
    protected $country;
    protected $city;
    protected $state;
    protected $colors;
    protected $sizes;

    
    function __construct(Category $categories,Country $country,City $city, State $state, ProductColor $colors, ProductSize $sizes) {
        $this->categories = $categories;
        $this->country = $country;
        $this->city = $city;
        $this->state = $state;
        $this->colors = $colors;
        $this->sizes = $sizes;
    }

    public function getAllRoles() {
        try {
          $roles = Role::select('id','name')->get()->except(1);
          return response()->json([ 'data' => $roles, 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function getPlanByRole($id) {

        try {
            $plan = Plan::where('role_id',$id)->first();
            if ($plan) {
                return response()->json([ 'data' => $plan, 'status' => 200 ]);
            }
            return response()->json(['message' => 'Plan Doesnt found' ,'status' => 401]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function getAllParentCategories(Request $request) {
        try {
          $categories =  $this->categories->getAllParentCategories($request);
          return response()->json([ 'data' => $categories, 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getSubCategoryByParent($categoryId) {
        try {
          $categories =  $this->categories->getSubCategoryByParent($categoryId);
          return response()->json([ 'data' => $categories, 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getAllBrands() {
        try {
          $brands =  Brand::get();
          return response()->json([ 'data' => $brands, 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getAllCountries(Request $request) {
        $countries =  $this->country->getAllCountries($request);
        return response()->json(['data' => $countries , 'status' => 200]);
    }

    public function getStateByCountry(GetStateByCountryRequest $request) {
        $states =   $this->state->getStateByCountry($request);
        return response()->json(['data' => $states,'status' => 200]);
    }

    public function getCityByState(GetCityByStateRequest $request) {
        $cities = $this->city->getCityByState($request);
        return response()->json(['data' => $cities , 'status' => 200]);
    }

    public function getAllColors() {
        $colors = $this->colors->getAllColors();
        return response()->json(['data' => $colors , 'status' => 200]);
    }

    public function getAllSizes() {
        $sizes = $this->sizes->getAllSizes();
        return response()->json(['data' => $sizes , 'status' => 200]);
    }
}
