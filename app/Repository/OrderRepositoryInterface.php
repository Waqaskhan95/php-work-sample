<?php

namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface OrderRepositoryInterface {
   public function addOrder(Request $request);
   public function getMyOrders(Request $request);
   public function orderDetail($id);

}