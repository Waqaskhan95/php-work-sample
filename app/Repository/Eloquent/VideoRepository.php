<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use App\Models\VideoLike;
use App\Models\CommentLike;
use App\Models\VideoView;
use App\Repository\VideoRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Owenoj\LaravelGetId3\GetId3;
use App\Http\Resources\VideoResource;
use Illuminate\Support\Facades\DB;

class VideoRepository extends BaseRepository implements VideoRepositoryInterface
{

   public function __construct(Video $model) {
       parent::__construct($model);
   }

   public function addVideo(Request $request) {
      $videoFile = $request->video;
      if($videoFile){
         $thumbnailFile = request()->file('thumbnail');
         $track = new GetId3(request()->file('video'));
         $trackInfo = $track->extractInfo(); //extract the info of video
         //convert the duration proper time format
         $playTimeString = $trackInfo['playtime_string'];
         $components = explode(":", $playTimeString);
         if (count($components) > 2) {
             list($hours, $minutes, $seconds) = $components;
         } else {
             $hours = 0;
             $minutes = $components[0] ?? 0;
             $seconds = $components[1] ?? 0;
         }
         $time = Carbon::createFromTime($hours, $minutes, $seconds);
         $duration = $time->format('H:i:s');
         //file upload
         $videoFileUpload = saveFile($videoFile, 'video/uploads', $videoFile->getClientOriginalName());
         $thumbnail = saveFile($thumbnailFile, 'video/images', $thumbnailFile->getClientOriginalName());
         $video = $this->model->create([
            'user_id'   => auth()->user()->id,
            'title'     => $request->title,
            'description' => $request->description,
            'video_location' => 'video/uploads/'. $videoFileUpload['name'],
            'thumbnail' => 'video/images/'. $thumbnail['name'],
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'category_id' => $request->category_id,
            'time' => Carbon::now()->format('H:i'),
            'duration' => $duration,
            'size' => $trackInfo['filesize'],  //in bytes
         ]);
         return ['message' => 'Video Added Successfully', 'status' => 200];
      }else{
         return ['message' => 'File not Found.', 'status' => 404];
      }
   }

   public function addShort(Request $request) {
      $short = $request->file('short');
      $thumbnailFile = $request->file('thumbnail');

      $track = new GetId3($short);
      $trackInfo = $track->extractInfo(); 
      $playTimeString = $trackInfo['playtime_string'];
      $components = explode(":", $playTimeString);
      
      if (count($components) > 2) {
          list($hours, $minutes, $seconds) = $components;
      } else {
          $hours = 0;
          $minutes = $components[0] ?? 0;
          $seconds = $components[1] ?? 0;
      }

      $time = Carbon::createFromTime($hours, $minutes, $seconds);
      $duration = $time->format('H:i:s');

      $shortObj = saveFile($short, 'short/uploads', $short->getClientOriginalName());
      $thumbnail = saveFile($thumbnailFile, 'short/images', $thumbnailFile->getClientOriginalName());

      $short = $this->model->create([
               'user_id'         => auth()->user()->id,
               'title'           => $request->title,
               'type'            => 'short',
               'description'     => $request->description,
               'video_location'  => $shortObj['path'],
               'thumbnail'       => $thumbnail['path'],
               'country_id'      => $request->country_id,
               'state_id'        => $request->state_id,
               'city_id'         => $request->city_id,
               'category_id'     => $request->category_id,
               'time'            => Carbon::now()->format('H:i'),
               'duration'        => $duration,
               'size'            => $trackInfo['filesize'],
               'is_short'        => 1  
      ]);

      return ['message' => 'Short Added Successfully', 'status' => 200];
   }

   public function addComment(Request $request) {
      if ($request->video_id) {
         $comment = Comment::create([
            'user_id'      => auth()->user()->id,
            'comment_id'   => $request->comment_id ?? null,
            'video_id'     => $request->video_id,
            'text'         => $request->text
         ]);

         return ['message' => 'Comment Added Successfully','status' => 200];
      }
   }

   public function addTimeStampComment(Request $request) {
      if ($request->video_id) {
         $comment = Comment::create([
            'user_id'      => auth()->user()->id,
            'comment_id'   => $request->comment_id ?? null,
            'video_id'     => $request->video_id,
            'text'         => $request->text,
            'type'         => 'timestamp',
            'url'          => $request->url,
            'link_timestamp'=> $request->link_timestamp,
            'status'       => 1
         ]);

         return ['message' => 'Comment Added Successfully','status' => 200];
      }
   }

   public function editComment(Request $request,$id) {
      $comment = Comment::find($id);
      if ($comment) {
         $comment->text = $request->text;
         $comment->save();
         return ['message' => 'Comment Updated Successfully','status' => 200];
      }

      return ['message' => 'Comment not found','status' => 301];
   }

   public function deleteComment($id) {
      $comment = Comment::find($id);
      if ($comment) {
         $comment->delete();
         return ['message' => 'Comment Deleted Successfully','status' => 200];
      }

      return ['message' => 'Comment not found','status' => 301];
   }

   public function toggleVideoLike($id) {
      $video = $this->model->find($id);
      if ($video) {
         $impression = VideoLike::where('user_id',auth()->user()->id)->where('video_id',$video->id)->first();
         if ($impression) {
            $impression->delete();
            $video->decrement('impression_likes');

            return ['message' => 'Video like removed','status' => 200];
         }else{
            VideoLike::create([
               'user_id'         => auth()->user()->id,
               'video_id'        => $video->id,
               'impression_type' => 'like'
            ]);
            $video->increment('impression_likes');

            return ['message' => 'Video liked','status' => 200];
         }

      }
      return ['message' => 'Video not found','status' => 301];
   }

   public function toggleCommentLike($id) {
      $comment = Comment::find($id);
      if ($comment) {
         $impression = CommentLike::where('user_id',auth()->user()->id)->where('comment_id',$comment->id)->where('impression_type',1)->first();
         if ($impression) {
            $impression->delete();
            $comment->decrement('impression_likes');

            return ['message' => 'Comment like removed','status' => 200];
         }else{
            $checkOtherImpression = CommentLike::where('user_id',auth()->user()->id)->where('comment_id',$comment->id)->where('impression_type',2)->first();
            if ($checkOtherImpression) {
               $checkOtherImpression->delete();
               $comment->decrement('impression_dislikes');
            }
            CommentLike::create([
               'user_id'         => auth()->user()->id,
               'comment_id'      => $comment->id,
               'impression_type' => 1
            ]);
            $comment->increment('impression_likes');

            return ['message' => 'Comment liked','status' => 200];
         }

      }
      return ['message' => 'Comment not found','status' => 301];
   }

   public function toggleCommentDislike($id) {
      $comment = Comment::find($id);
      if ($comment) {
         $impression = CommentLike::where('user_id',auth()->user()->id)->where('comment_id',$comment->id)->where('impression_type',2)->first();
         if ($impression) {
            $impression->delete();
            $comment->decrement('impression_dislikes');
            return ['message' => 'Comment like removed','status' => 200];
         }else{
            $checkOtherImpression = CommentLike::where('user_id',auth()->user()->id)->where('comment_id',$comment->id)->where('impression_type',1)->first();
            if ($checkOtherImpression) {
               $checkOtherImpression->delete();
               $comment->decrement('impression_likes');
            }
            CommentLike::create([
               'user_id'         => auth()->user()->id,
               'comment_id'      => $comment->id,
               'impression_type' => 2
            ]);
            $comment->increment('impression_dislikes');

            return ['message' => 'Comment Disliked','status' => 200];
         }

      }
      return ['message' => 'Comment not found','status' => 301];
   }

   public function listVideos(Request $request) {
      $videos = $this->model->where('type','video');

      if ($request->category_id) {
         $videos = $videos->where('category_id',$request->category_id);
      }

      if ($request->entries) {
         $videos = $videos->paginate($request->entries);
         $videoCollection = VideoResource::collection($videos)->response()->getData(true);
         return ['data' => paginate($videoCollection),'status' => 200 ];
      }elseif ($request->limit) {
         $videos = $videos->orderByDesc('id')->take($request->limit)->get();
         return ['data' => VideoResource::collection($videos),'status' => 200 ];
      }else{
         $videos = $videos->paginate(10);
         $videoCollection = VideoResource::collection($videos)->response()->getData(true);
         return ['data' => paginate($videoCollection),'status' => 200 ];
      }
   }

   public function getRecentShort(Request $request) {
      $videos = $this->model->where('type','short');

      if ($request->entries) {
         $videos = $videos->paginate($request->entries);
         $videoCollection = VideoResource::collection($videos)->response()->getData(true);
         return ['data' => paginate($videoCollection),'status' => 200 ];
      }elseif ($request->limit) {
         $videos = $videos->orderByDesc('id')->take($request->limit)->get();
         return ['data' => VideoResource::collection($videos),'status' => 200 ];
      }else{
         $videos = $videos->paginate(10);
         $videoCollection = VideoResource::collection($videos)->response()->getData(true);
         return ['data' => paginate($videoCollection),'status' => 200 ];
      }
   }

   public function getUserVideos(Request $request,$id) {
      $videos = $this->model->where('type','video')->where('user_id',$id);

      if ($request->entries) {
         $videos = $videos->paginate($request->entries);
         $videoCollection = VideoResource::collection($videos)->response()->getData(true);
         return ['data' => paginate($videoCollection),'status' => 200 ];
      }elseif ($request->limit) {
         $videos = $videos->orderByDesc('id')->take($request->limit)->get();
         return ['data' => VideoResource::collection($videos),'status' => 200 ];
      }else{
         $videos = $videos->paginate(10);
         $videoCollection = VideoResource::collection($videos)->response()->getData(true);
         return ['data' => paginate($videoCollection),'status' => 200 ];
      }
   }

   public function getUserShorts(Request $request,$id) {
      $videos = $this->model->where('type','short')->where('user_id',$id);

      if ($request->entries) {
         $videos = $videos->paginate($request->entries);
         $videoCollection = VideoResource::collection($videos)->response()->getData(true);
         return ['data' => paginate($videoCollection),'status' => 200 ];
      }elseif ($request->limit) {
         $videos = $videos->orderByDesc('id')->take($request->limit)->get();
         return ['data' => VideoResource::collection($videos),'status' => 200 ];
      }else{
         $videos = $videos->paginate(10);
         $videoCollection = VideoResource::collection($videos)->response()->getData(true);
         return ['data' => paginate($videoCollection),'status' => 200 ];
      }
   }

   public function videoDetail($id) {
      
      $video = $this->model->find($id);
      if ($video) {
         return ['data' => new VideoResource($video),'status' => 200 ];
      }else{
         return ['data' => null,'message' => 'Video Not Found','status' => 200 ];
      }
   }

   public function relatedVideos($id) {
      
      $video = $this->model->find($id);

      $getRelatedVideos = $this->model->where('type','video');
      if ($video->country_id) {
         // $getRelatedVideos = $getRelatedVideos->where('country_id',$video->country_id);
      }

      $getRelatedVideos = $getRelatedVideos->where('id', '!=', $id)
                                     ->take(6)
                                     ->orderByDesc('id')
                                     ->get();

      if ($getRelatedVideos) {
         return ['data' => VideoResource::collection($getRelatedVideos),'status' => 200 ];
      }else{
         return ['data' => null,'message' => 'Video Not Found','status' => 200 ];
      }
   }

   public function addViewOnVideo(Request $request,$id) {
      $video = $this->model->find($id);
      if ($video) {
         $ip = request()->ip();
         $findView = VideoView::where('ip_address',$ip)->where('video_id',$id);

         if ($request->user_id) {
            $findView = $findView->where('user_id',$request->user_id);            
         }

         $findView = $findView->first();

         if (!$findView) {
            $view = new VideoView();

            $view->ip_address = $ip;
            $view->video_id = $id;
            if($request->user_id){
               $view->user_id = $request->user_id;
            }
            $view->save();
            $video->increment('views');

            return [
               'message'   => 'View Added Successfully',
               'status'    => 200
            ];

         }else{
            return [
               'message'  => 'View Already Added',
               'status'   => 200 
            ];
         }

      }

      return [
         'message' => 'Video Or Short Not Found',
         'status'  => 404 
      ];
   }

   public function getMyViewsAnalytics(Request $request) {
      
   $userId = auth()->user()->id; // Assuming you have the authenticated user ID
   $currentWeekStartDate = Carbon::now()->startOfWeek()->toDateString();
   $currentWeekEndDate = Carbon::now()->endOfWeek()->toDateString();

   $checkVideo = Video::where('user_id',$userId)->pluck('id');
   $videoViews = VideoView::select(
        DB::raw('DATE(created_at) AS date'), 
        DB::raw('COUNT(id) AS total_views')
    )->whereIn('video_id', $checkVideo)->whereBetween('created_at', [$currentWeekStartDate, $currentWeekEndDate])
    ->groupBy('date')->orderBy('date')->get()->toArray();

   $videoLikes =  VideoLike::select(
        DB::raw('DATE(created_at) AS date'), 
        DB::raw('COUNT(id) AS total_likes')
    )->whereIn('video_id', $checkVideo)->whereBetween('created_at', [$currentWeekStartDate, $currentWeekEndDate])
    ->groupBy('date')->orderBy('date')->get()->toArray();

    return [
      'data' => [
         'date_from' => $currentWeekStartDate,
         'date_to'   => $currentWeekEndDate,
         'likes' => $videoLikes,
         'views' => $videoViews,
      ],
      'status' => 200
    ];   
   }

}