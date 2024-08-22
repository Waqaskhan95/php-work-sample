<?php

namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface EventRepositoryInterface {
   public function addEvent(Request $request);
   public function editEvent(Request $request,$id);
   public function eventToItChain(Request $request);
   public function getEventList(Request $request);
   public function eventDetail($id);
   public function getMyItChain(Request $request);
   // eventToItChain

}