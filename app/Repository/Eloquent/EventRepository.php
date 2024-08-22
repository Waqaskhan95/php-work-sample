<?php

namespace App\Repository\Eloquent;

use App\Models\Event;
use App\Models\EventItChain;
use App\Repository\EventRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use App\Http\Resources\ItChainResource;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{

   public function __construct(Event $model)
   {
       parent::__construct($model);
   }

   public function addEvent(Request $request) {

      $image = null;

      if (!empty($request->thumbnail)) {
         $thumbnail = $request->thumbnail;
         $image = saveFile($thumbnail, 'event/uploads', $thumbnail->getClientOriginalName());

      }

       $event = $this->model->create([
         'name'         => $request->name,
         'user_id'      => auth()->user()->id,
         'category_id'  => $request->category_id,
         'country_id'   => $request->country_id,
         'state_id'     => $request->state_id,
         'city_id'      => $request->city_id,
         'date'         => $request->date,
         'location'     => $request->location,
         'lat'          => $request->lat ?? null,
         'lng'          => $request->lng ?? null,
         'description'  => $request->description ?? null,
         'thumbnail'    => $image['path'] ?? null
       ]);

       return $event;
   }

   public function editEvent(Request $request,$id) {
      $event = $this->model->find($id);

      if ($request->name) {
         $event->name = $request->name;
      }

      if ($request->category_id) {
         $event->category_id = $request->category_id;
      }
      
      if ($request->country_id) {
         $event->country_id = $request->country_id;
      }
      
      if ($request->state_id) {
         $event->state_id = $request->state_id;
      }
      
      if ($request->city_id) {
         $event->city_id = $request->city_id;
      }
      
      if ($request->location) {
         $event->location = $request->location;
      }
      
      if ($request->lat) {
         $event->lat = $request->lat;
      }
      
      if ($request->lng) {
         $event->lng = $request->lng;
      }
      
      if ($request->description) {
         $event->description = $request->description;
      }

      $image = null;

      if (!empty($request->file('thumbnail'))) {
         $thumbnail = $request->thumbnail;
         $image = saveFile($thumbnail, 'event/uploads', $thumbnail->getClientOriginalName());
         $event->thumbnail = $image['path'] ?? null;
      }

      $event->save();


      return $event;

   }

   public function eventToItChain(Request $request){
      for ($i=0; $i <count($request->event_id) ; $i++) { 
        
            EventItChain::updateOrCreate(
               [
                  'event_id' => $request->event_id[$i],
                  'user_id' => auth()->user()->id,
               ],
               [
                  'event_id' => $request->event_id[$i],
                  'user_id' => auth()->user()->id,
                  'order' => $request->order[$i] ?? 0,
               ]
            );
      }

      return true;
   }

   public function getEventList(Request $request) {
      $events = $this->model;

      if ($request->date) {
         $events = $events->whereDate('date',$request->date);
      }

      if ($request->name) {
         $events = $events->where('name',$request->name);
      }

      $events = $events->orderByDesc('id')->paginate(10);

      $eventCollection = EventResource::collection($events)->response()->getData(true);
      return [
         'data'   => paginate($eventCollection),
         'status' => 200 
      ];
   }

   public function eventDetail($id) {
      $event = $this->model->find($id);

      return [
         'data' => new EventResource($event),
         'status' => 200
      ];
   }

   public function getMyItChain(Request $request) {
      $events = EventItChain::where('user_id',auth()->user()->id);
      // $events = $events->whereDate('date','>',now());

      $events = $events->get();

      return [
         'data'   => ItChainResource::collection($events),
         'status' => 200
      ];

   }
}