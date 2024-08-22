<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\ProductRepositoryInterface;
use Exception;

class ProductController extends Controller
{
    protected $productInterface;
    function __construct(ProductRepositoryInterface $productInterface)
    {
        $this->productInterface = $productInterface;
    }

    public function addProduct(Request $request) {
        try {
          $product = $this->productInterface->addProduct($request);  
          return response()->json([ 'message' => 'Product Added Successfully', 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function toggleProductWishlist($id) {
        try {
          $product = $this->productInterface->toggleProductWishlist($id);  
          return response()->json($product);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }  
    }

    public function getMyWishlist(Request $request) {
        try {
          $products = $this->productInterface->getMyWishlist($request);  
          return response()->json($products);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }  
    }

    public function addProductRating(Request $request,$id) {
        try {
          $product = $this->productInterface->addProductRating($request,$id);  
          return response()->json($product);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getMyProductRating(Request $request,$productId) {
        try {
          $rating = $this->productInterface->getMyProductRating($request, $productId);  
          return response()->json($rating);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getMyProducts(Request $request) {
        try {
          $products = $this->productInterface->getMyProducts($request);  
          return response()->json(['data' => $products , 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getAllProducts(Request $request) {
        try {
          $products = $this->productInterface->getAllProducts($request);  
          return response()->json(['data' => $products , 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getProductById(Request $request, $productId) {
        try {
          $data = $this->productInterface->getProductById($request, $productId);  
          return $data;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function deleteProduct($id) {
        try {
          $product = $this->productInterface->deleteProduct($id);  
          return response()->json($product);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }
}
