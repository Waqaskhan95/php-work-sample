<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;

class StreamingController extends Controller
{
    private $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );
    }

    public function startStream(Request $request)
    {
        $this->pusher->trigger('stream', 'start-stream', []);

        return response()->json(['message' => 'Stream started']);
    }

    public function stopStream(Request $request)
    {
        $this->pusher->trigger('stream', 'stop-stream', []);

        return response()->json(['message' => 'Stream stopped']);
    }
}
