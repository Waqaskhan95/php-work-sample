<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getAllParentCategories(Request $request) {
       $categories = $this->where('parent',0);
       if ($request->type) {
           $categories = $categories->where('type',$request->type);
       }
       $categories = $categories->get();
       return $categories; 
    }

    public function getSubCategoryByParent($id) {
        $categories = $this->where('parent',$id)->get();
        return $categories;
    }
}
