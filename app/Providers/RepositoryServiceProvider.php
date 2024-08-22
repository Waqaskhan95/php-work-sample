<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\UserRepositoryInterface;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\EventRepositoryInterface;
use App\Repository\VideoRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\ConversationRepositoryInterface;
use App\Repository\GlobalNotificationRepositoryInterface;
use App\Repository\Eloquent\UserRepository; 
use App\Repository\Eloquent\OrderRepository; 
use App\Repository\Eloquent\BaseRepository; 
use App\Repository\Eloquent\ProductRepository; 
use App\Repository\Eloquent\EventRepository; 
use App\Repository\Eloquent\GlobalNotificationRepository; 
use App\Repository\Eloquent\VideoRepository; 
use App\Repository\Eloquent\ConversationRepository; 

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(ConversationRepositoryInterface::class, ConversationRepository::class);
        $this->app->bind(GlobalNotificationRepositoryInterface::class, GlobalNotificationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
