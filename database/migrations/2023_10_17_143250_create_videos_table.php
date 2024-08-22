<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 255);
            $table->longText('description')->nullable();
            $table->string('thumbnail', 500)->default('video/images/thumbnail.jpg');
            $table->string('video_location', 3000);
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->string('sanctioning_body')->nullable();
            $table->string('race_discipline')->nullable();
            $table->timestamp('race_heat_timestamp')->nullable();
            $table->time('time');
            $table->text('result_link')->nullable();
            $table->text('location')->nullable();
            $table->text('tags')->nullable();
            $table->time('duration')->default('00:00');
            $table->bigInteger('size')->default(0);
            $table->integer('views')->default(0);
            // $table->integer('privacy')->default(0);
            $table->tinyInteger('age_restriction')->default(1);
            // $table->string('type')->nullable();
            $table->integer('approved')->default(1);
            // $table->unsignedFloat('sell_video')->default(0);
            $table->integer('is_movie')->default(0);
            $table->string('stars')->nullable();
            $table->string('producer')->nullable();
            $table->string('movie_release')->nullable();
            $table->string('quality')->nullable();
            $table->string('rating')->nullable();
            $table->integer('monetization')->default(1);
            $table->integer('rent_price')->default(0);
            $table->string('stream_name')->nullable();
            $table->bigInteger('live_time')->default(0);
            $table->integer('live_ended')->default(0);
            $table->longText('agora_resource_id')->nullable();
            $table->string('agora_sid', 500)->nullable();
            $table->longText('agora_token')->nullable();
            $table->string('license', 100)->nullable();
            $table->integer('is_stock')->default(0);
            $table->string('trailer', 3000)->nullable();
            $table->integer('embedding')->default(0);
            $table->string('live_chating', 11)->default('on');
            $table->date('publication_date')->nullable();
            $table->integer('is_short')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
