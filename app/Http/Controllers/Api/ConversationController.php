<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\ConversationRepositoryInterface;
use Exception;
use App\Http\Requests\ConversationMessageRequest;
use App\Http\Requests\SentMessageRequest;

class ConversationController extends Controller
{
    protected $conversation;
    function __construct(ConversationRepositoryInterface $conversation) {
        $this->conversation = $conversation;
    }

    public function initiateConversation($id) {
        try {
          $conversation = $this->conversation->initiateConversation($id);  
          return response()->json($conversation);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getMyConversations(Request $request) {
        try {
          $conversation = $this->conversation->getMyConversations($request);  
          return response()->json($conversation);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function getConversationMessages(ConversationMessageRequest $request) {
        try {
          $conversation = $this->conversation->getConversationMessages($request);  
          return response()->json($conversation);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function sentMessageOnConversation(SentMessageRequest $request) {
        try {
          $conversation = $this->conversation->sentMessageOnConversation($request);  
          return response()->json($conversation);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }
}
