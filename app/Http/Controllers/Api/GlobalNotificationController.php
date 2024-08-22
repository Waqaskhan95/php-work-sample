<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\GlobalNotificationRepositoryInterface;
use Exception;

class GlobalNotificationController extends Controller
{
    protected $global_notification;
    function __construct(GlobalNotificationRepositoryInterface $global_notification) {
        $this->global_notification = $global_notification;
    }

    public function getMyNotifications(Request $request) {
        try {
            $notifications = $this->global_notification->getMyNotifications($request);
            return response()->json($notifications);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getMyRecentNotifications(Request $request) {
        try {
            $notifications = $this->global_notification->getMyRecentNotifications($request);
            return response()->json($notifications);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getUnseenNotifications(Request $request) {
        try {
            $notifications = $this->global_notification->getUnseenNotifications($request);
            return response()->json($notifications);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function seenNotification($id) {
        try {
            $notifications = $this->global_notification->seenNotification($id);
            return response()->json($notifications);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function seenAllNotifications() {
        try {
            $notifications = $this->global_notification->seenAllNotifications();
            return response()->json($notifications);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function clearNotifications() {
        try {
            $notifications = $this->global_notification->clearNotifications();
            return response()->json($notifications);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getMyUnseenNotitificationCount() {
        try {
            $notifications = $this->global_notification->getMyUnseenNotitificationCount();
            return response()->json($notifications);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }
}
