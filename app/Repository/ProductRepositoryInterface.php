<?php

namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
   public function getAllProducts(Request $request);
   public function getMyProducts(Request $request);
   public function getProductById(Request $request, $productId);
   public function addProduct(Request $request);
   public function toggleProductWishlist($id);
   public function getMyWishlist(Request $request);
   public function addProductRating(Request $request,$id);
   public function getMyProductRating(Request $request,$productId);
   public function deleteProduct($productId);
   
}