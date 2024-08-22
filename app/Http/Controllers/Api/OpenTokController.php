<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenTok\OpenTok;
use OpenTok\Role;
use OpenTok\MediaMode;

class OpenTokController extends Controller
{
    public function createSession() {
        try {
            $apiKey = config('vonage.api_key');
            $apiSecret = config('vonage.api_secret');
            $opentok = new OpenTok($apiKey, $apiSecret);
            // dd($opentok);
            $session = $opentok->createSession(['mediaMode' => MediaMode::ROUTED]);
            
            $sessionId = $session->getSessionId();
            dd($sessionId);
    
            return response()->json(['sessionId' => $sessionId]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function generateToken(Request $request) {
        $sessionId = $request->input('sessionId');

        $apiKey = config('vonage.api_key');
        $apiSecret = config('vonage.api_secret');
    
        $opentok = new OpenTok($apiKey, $apiSecret);
    
        // Generate a token with the desired role (publisher, subscriber, or moderator)
        // and data indicating screen-sharing capability
        $token = $opentok->generateToken($sessionId, [
            'role' => Role::PUBLISHER,
            'data' => 'screen-sharing-capable',
        ]);
    
        return response()->json(['token' => $token]);
    }
}
