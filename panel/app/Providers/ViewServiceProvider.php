<?php

namespace App\Providers;

use App\Http\View\Composers\JoinedTeamsComposer;
use App\Http\View\Composers\TeamsComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layout.nav', TeamsComposer::class);
        View::composer('layout.nav', JoinedTeamsComposer::class);
    }
}
