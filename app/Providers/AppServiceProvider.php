<?php

namespace App\Providers;


use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer("posts.form", function($view)
        {
            $view->with("tags", Tag::all());
        });

        //
        Post::saved(function($post) {
            Cache::forget("all-posts");
        });

        Post::deleted(function($post) {
            Cache::forget("all-posts");
        });
    }
}
