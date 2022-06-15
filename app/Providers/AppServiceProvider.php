<?php

namespace App\Providers;

use App\ChangeFactor;
use App\ChangeOrder;
use App\Note;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with([
                'notes_count' => Note::where('view', 0)->count(),
                'change_count' => ChangeOrder::where('seen', 0)->count(),
            ]);
        });
    }
}
