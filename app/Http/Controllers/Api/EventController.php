<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\EventRepositoryInterface;
use Exception;


class EventController extends Controller
{
    protected $event;
    function __construct(EventRepositoryInterface $event) {
        $this->event = $event;
    }

    public function addEvent(Request $request) {
        try {
          $event = $this->event->addEvent($request);  
          return response()->json([ 'message' => 'Event Added Successfully', 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function editEvent(Request $request,$id) {
        try {
          $event = $this->event->editEvent($request,$id);  
          return response()->json([ 'message' => 'Event Updated Successfully', 'status' => 200 ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function eventToItChain(Request $request) {
        try {
            $chain = $this->event->eventToItChain($request);
            return response()->json([ 'message' => 'Event Added To IT Chain', 'status' => 200 ]);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getEventList(Request $request) {
        try {
            $events = $this->event->getEventList($request);
            return response()->json($events);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function eventDetail($id) {
        try {
            $event = $this->event->eventDetail($id);
            return response()->json($event);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }   
    }

    public function getMyItChain(Request $request) {
        try {
            $event = $this->event->getMyItChain($request);
            return response()->json($event);  
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }
}
