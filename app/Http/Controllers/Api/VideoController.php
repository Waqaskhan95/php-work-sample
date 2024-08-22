<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\VideoRepositoryInterface;
use App\Http\Requests\AddShortRequest;
use Exception;

class VideoController extends Controller
{
    protected $video;
    function __construct(VideoRepositoryInterface $video) {
        $this->video = $video;
    }

    public function addVideo(Request $request) {
        // dd($request->all());
        try {
          $video = $this->video->addVideo($request);  
          return response()->json($video);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function addShort(AddShortRequest $request) {
        try {
             $short = $this->video->addShort($request);  
             return response()->json($short);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function addComment(Request $request) {
        try {
             $comment = $this->video->addComment($request);  
             return response()->json($comment);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function addTimeStampComment(Request $request) {
        try {
             $comment = $this->video->addTimeStampComment($request);  
             return response()->json($comment);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function editComment(Request $request,$id) {
        try {
             $comment = $this->video->editComment($request,$id);  
             return response()->json($comment);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function deleteComment($id) {
        try {
             $comment = $this->video->deleteComment($id);  
             return response()->json($comment);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function toggleVideoLike($id) {
        try {
             $likeImpression = $this->video->toggleVideoLike($id);  
             return response()->json($likeImpression);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function toggleCommentLike($id) {
        try {
             $likeImpression = $this->video->toggleCommentLike($id);  
             return response()->json($likeImpression);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function toggleCommentDislike($id) {
        try {
             $likeImpression = $this->video->toggleCommentDislike($id);  
             return response()->json($likeImpression);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

    public function listVideos(Request $request) {
       try {
             $list = $this->video->listVideos($request);  
             return response()->json($list);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function getUserVideos(Request $request,$id) {
       try {
             $list = $this->video->getUserVideos($request,$id);  
             return response()->json($list);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function getUserShorts(Request $request,$id) {
       try {
             $list = $this->video->getUserShorts($request,$id);  
             return response()->json($list);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function videoDetail($id) {
       try {
             $video = $this->video->videoDetail($id);  
             return response()->json($video);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function relatedVideos($id) {
       try {
             $videos = $this->video->relatedVideos($id);  
             return response()->json($videos);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        } 
    }

    public function addViewOnVideo(Request $request,$id) {
        try {
             $view = $this->video->addViewOnVideo($request,$id);  
             return response()->json($view);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }  
    }

    public function getMyViewsAnalytics(Request $request) {
        try {
             $report = $this->video->getMyViewsAnalytics($request);  
             return response()->json($report);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }  
    }

    public function getRecentShort(Request $request) {
        try {
             $list = $this->video->getRecentShort($request);  
             return response()->json($list);
        } catch (Exception $e) {
             return response()->json(['message' => $e->getMessage() ,'status' => 500]);
        }
    }

}
