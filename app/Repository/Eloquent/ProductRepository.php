<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\Wishlist;
use App\Models\ProductRating;
use App\Models\ProductVariation;
use App\Models\ProductColor;
use App\Models\ProductFaq;
use App\Models\ProductSize;
use App\Http\Resources\ProductResource;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

   public function __construct(Product $model) {
       parent::__construct($model);
   }


   public function getAllProducts(Request $request) {
      $products = $this->model;
      if ($request->name) {
         $products = $products->where('name','LIKE', '%'.$request->name.'%');       
      }   
      $products = $products->paginate(env('APP_PAGINATE',10));
      $collectionData = ProductResource::collection($products)->response()->getData(true);

      return paginate($collectionData);
   }

   public function getMyProducts(Request $request) {
      $products = $this->model->where('user_id',auth()->user()->id);
      if ($request->name) {
         $products = $products->where('name','LIKE', '%'.$request->name.'%');       
      } 
      $products = $products->paginate(env('APP_PAGINATE',10));
      $collectionData = ProductResource::collection($products)->response()->getData(true);
      return paginate($collectionData);
   }

   public function getProductById(Request $request, $id) {
      $product = $this->model->find($id);
      if($product){
         $product = new ProductResource($product);
         return response()->json(['data' => $product , 'status' => 200 ]);
      }else{
         return response()->json(['data' => null, 'message' => 'Product does not exist', 'status' => 404 ]);
      }
   }

   public function addProduct(Request $request) {
      $product = $this->model->create([
         'name'         => $request->name,
         'category_id'  => $request->category_id,
         'brand_id'     => $request->brand_id,
         'user_id'      => auth()->user()->id,
         'price'        => $request->price,
         'description'  => $request->description,
         'status'       => 0
      ]);
      if ($request->has('images')) {

         $saveImages = [];
         foreach ($request->images as $key => $image) {
            $fileName = $image->getClientOriginalName();  
            $saveImages[] = saveFile($image, 'images/product', $fileName);
            if ($key == 0) {
               $saveImages[0]['is_featured'] = true;
            }

         }
         $product->images()->createMany($saveImages);
      }

      if ($request->has('variation')) {
         $variations = json_decode($request->variation);
         for ($i = 0; $i < count($variations); $i++) {
            $product_variation = $variations[$i];
            ProductVariation::create([
               'product_id' => $product->id,
               'name' => $product_variation->name,
               'price' => $product_variation->price,
               'stock_quantity' => $product_variation->stock_quantity,
               'color_id' => $product_variation->color_id,
               'size_id' => $product_variation->size_id,
            ]);
         }
      }

      return $product;
   }

   public function toggleProductWishlist($id) {
      $product = $this->model->find($id);

      if ($product) {
         $wishlist = Wishlist::where('product_id',$product->id)->where('user_id',auth()->user()->id)->first();
         if ($wishlist) {
            $wishlist->delete();
            return ['message' => 'Removed From wishlist','status' => 200 ];
         }else{
            Wishlist::create([
               'product_id' => $product->id,
               'user_id'   => auth()->user()->id
            ]);
            return ['message' => 'Added to wishlist','status' => 200 ];
         }
      }else{
         return ['message' => 'product doesnot found', 'status' => 200];
      }
   }

   public function getMyWishlist(Request $request) {
      $productIds = Wishlist::where('user_id',auth()->user()->id)->pluck('product_id');

      $products = $this->model->whereIn('id',$productIds)->get();
      $collectionData = ProductResource::collection($products);

      return[
         'data' => $collectionData,
         'status' => 200
      ];

   }

   public function addProductRating(Request $request,$id) {
      $product = $this->model->find($id);
      if ($product) {
         ProductRating::updateOrCreate(
            [
               'product_id' => $product->id,
               'user_id' => auth()->user()->id,
            ],
            [
               'rating'     => $request->rating,
               'comment'     => $request->comment 
            ]
         );
         return ['message' => 'Product rating added successfully','status' => 200 ];
      }

      return ['message' => 'product doesnot found', 'status' => 200];
   }

   public function getMyProductRating(Request $request,$productId) {
      $rating = ProductRating::where('user_id', auth()->user()->id)->where('product_id', $productId)->first();
      if($rating){
         return ['data' => $rating->rating, 'status' => 200 ];
      }
      return ['data' => null, 'status' => 200 ];
   }

   public function deleteProduct($id) {
      $product = $this->model->find($id);

      if ($product) {
         $ratings = ProductRating::where('product_id',$id)->delete();
         $variations = ProductVariation::where('product_id',$id)->delete();
         $product->delete();
      }

      return [
         'message'   => 'Product Deleted Successfully',
         'status'    => 200
      ];
   }
    
}