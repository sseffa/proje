<?php

namespace App\Providers;

use App\Repositories\CommentRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\MeetingRepository;
use App\Repositories\Eloquent\PostRepository;
use App\Repositories\Eloquent\ReplyRepository;
use App\Repositories\Eloquent\TeamRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\MeetingRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\ReplyRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(MeetingRepositoryInterface::class, MeetingRepository::class);
        $this->app->bind(ReplyRepositoryInterface::class, ReplyRepository::class);
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
