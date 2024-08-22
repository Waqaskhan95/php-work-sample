<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comment_id' => $this->comment_id,
            'user' => new UserResource(User::find($this->user_id)),
            'video_id' => $this->video_id,
            'text'  => $this->text,
            'impression_likes' => $this->impression_likes,
            'impression_dislikes' => $this->impression_dislikes,
            'type' => $this->type,
            'url' => $this->url,
            'link_timestamp' => $this->link_timestamp,
            'has_child' => $this->replies_count ?? 0,
            'replies'   => $this->replies ? CommentResource::collection($this->replies) : null,
        ];
    }
}
