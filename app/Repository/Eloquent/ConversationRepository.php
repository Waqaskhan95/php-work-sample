<?php

namespace App\Repository\Eloquent;

use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Repository\ConversationRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\ConversationResource;

class ConversationRepository extends BaseRepository implements ConversationRepositoryInterface
{

   public function __construct(Conversation $model)
   {
       parent::__construct($model);
   }

   public function initiateConversation($id) {
      $userId = auth()->user()->id;

      $result = $this->model
                ->where(function ($query) use ($userId, $id) {
                    $query->where('from_user', $userId)->where('to_user', $id)
                        ->orWhere('to_user', $userId)->where('from_user', $id);
                })
                ->first();

      if ($result) {

            return [
               'message' => 'Conversation Initated',
               'data' => $result,
               'status' => 200
            ];

      }else{

         $result = $this->model->create([
            'from_user' => auth()->user()->id,
            'to_user'   => $id,
            'status'    => 1,
         ]);

         return [
            'message' => 'Conversation Initated',
            'data' => $result,
            'status' => 200
         ];
      }          
   }

   public function getMyConversations(Request $request) {
      $userId = auth()->user()->id;

      $result = $this->model
          ->with(['toUser', 'fromUser'])
          ->where(function ($query) use ($userId) {
              $query->where('from_user', $userId)->orWhere('to_user', $userId);
          })
          ->get();


      return [
         'data' => ConversationResource::collection($result),
         'status' => 200
      ];    
   }

   public function getConversationMessages(Request $request) {
      
      $result = $this->model->find($request->conversation_id);
      return [
         'data' => $result->messages,
         'status' => 200
      ];
   }

   public function sentMessageOnConversation(Request $request) {
      
      $message = ConversationMessage::create([
                  'conversation_id' => $request->conversation_id,
                  'message'         => $request->message,
                  'user_id'         => auth()->user()->id,
                  'seen'            => 0
                ]);

      return [
         'message' => 'Message Sent Successfully',
         'data'    => $message,
         'status'  => 200    
      ];
   }
}