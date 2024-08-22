<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface GlobalNotificationRepositoryInterface {
   public function add($user_id,$message);
   public function getMyNotifications(Request $request);
   public function getMyRecentNotifications(Request $request);
   public function getUnseenNotifications(Request $request);
   public function seenNotification($id);
   public function seenAllNotifications();
   public function clearNotifications();
   public function getMyUnseenNotitificationCount();
}