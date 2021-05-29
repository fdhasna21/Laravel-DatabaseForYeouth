<?php

namespace App\Providers;

use App\Models\Image;
use App\Models\OrderInfo;
use App\Models\UserDetail;
use App\Models\UserWishlist;
use App\Observers\CreatedAtObserver;
use App\Observers\UpdatedAtObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        OrderInfo::observe(CreatedAtObserver::class);
        UserDetail::observe(UpdatedAtObserver::class);
        UserWishlist::observe(CreatedAtObserver::class);
        Image::observe(CreatedAtObserver::class);
    }
}
