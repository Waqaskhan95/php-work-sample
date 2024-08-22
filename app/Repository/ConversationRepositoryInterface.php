<?php

namespace App\Repository;

use Illuminate\Http\Request;

interface ConversationRepositoryInterface {
   public function initiateConversation($id);
   public function getMyConversations(Request $request);
   public function getConversationMessages(Request $request);
   public function sentMessageOnConversation(Request $request);

}