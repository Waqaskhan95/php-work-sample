<?php

namespace App\Repository\Eloquent;

use App\Models\GlobalNotification;
use App\Repository\GlobalNotificationRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\GlobalNotificationResource;

class GlobalNotificationRepository extends BaseRepository implements GlobalNotificationRepositoryInterface
{

   public function __construct(GlobalNotification $model)
   {
       parent::__construct($model);
   }

   public function add($user_id,$message) {

      $notification = $this->model->create([
         'user_id' => $user_id,
         'message' => $message
      ]);

      return $notification;

   }

   public function getMyNotifications(Request $request){
       $query =  $this->model;
       $query = $query->where('user_id',auth()->user()->id);
       $query = $query->paginate(env('APP_PAGINATE',10));
       $collection = GlobalNotificationResource::collection($query)->response()->getData(true);
       return [
         'data' => paginate($collection),
         'status' => 200
       ];
   }

   public function getMyRecentNotifications(Request $request){
       $query =  $this->model;
       $query = $query->where('user_id',auth()->user()->id);
       $query = $query->orderByDesc('id')->take(10)->get();

       return [
         'data' => GlobalNotificationResource::collection($query),
         'status' => 200
       ];
   }

   public function getUnseenNotifications(Request $request) {
        $query =  $this->model;

        $query = $query->where('user_id',auth()->user()->id);
        $query = $query->where('is_seen',0);
        $query = $query->paginate(env('APP_PAGINATE',10));

        return [
         'data' => $query,
         'status' => 200
         ];
   }

   public function seenNotification($id) {
       $notification = $this->model->find($id);
       $notification->is_seen = 1;
       $notification->save();

      return [
         'data' => $notification,
         'status' => 200
      ];
   }

   public function seenAllNotifications() {
      $notifications = $this->model->where('user_id',auth()->user()->id)->get();

      if (count($notifications)) {
         foreach ($notifications as $key => $notification) {
            $notification->is_seen = 1 ;
            $notification->save();
         }
      }

      return [
         'message' => 'Seen All Notifications',
         'status'  => 200
      ];
   }

   public function clearNotifications() {
      $notifications = $this->model->where('user_id',auth()->user()->id)->get();

      if (count($notifications)) {
         foreach ($notifications as $key => $notification) {
            $notification->delete();
         }
      }

      return [
         'message' => 'Removed All Notifications',
         'status'  => 200
      ];
   }

   public function getMyUnseenNotitificationCount() {
      $count = $this->model->where('user_id',auth()->user()->id)->where('is_seen',0)->count();

      return [
         'data' => $count,
         'status' => 200
      ];
   }

}