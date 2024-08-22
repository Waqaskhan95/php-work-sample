<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description','type', 'thumbnail', 'video_location', 'country_id', 'state_id', 'city_id', 
    'category_id', 'sub_category_id', 'event_id', 'sanctioning_body', 'race_discipline', 'race_heat_timestamp', 'time', 'result_link',
    'location', 'tags', 'duration', 'size', 'views', 'age_restriction', 'approved', 'is_movie', 'stars', 'producer', 'movie_release',
    'quality', 'rating', 'monetization', 'rent_price', 'stream_name', 'live_time', 'live_ended', 'agora_resource_id', 'agora_sid', 'agora_token', 'license', 'is_stock', 'trailer', 'embedding', 'live_chating', 'publication_date', 'is_short'
        ];


    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('comment_id')->where('status',1);
    }    
}
