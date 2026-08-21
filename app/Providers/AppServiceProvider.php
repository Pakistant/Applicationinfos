<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\KioskIssue;
use App\Models\Settings;
use App\Models\SocialMedia;
use Conner\Tagging\Model\Tag;
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
        if ($this->app->runningInConsole()) {
            return;
        }

        $socials = SocialMedia::orderBy('id','DESC')->get();
        $categories = Category::where('isActive',1)->orderBy('created_at', 'DESC')->get();
        $articles = Article::where('isActive',1)->orderBy('created_at','DESC')->limit(5)->get();
        $tags = Tag::orderBy('id','DESC')->limit(15)->get();
        $settings=Settings::where('id',1)->first();
        $famous_articles = Article::where('isActive',1)->orderBy('created_at','DESC')->orderBy('views','DESC')->limit(3)->get();
        $kiosk_issues = KioskIssue::where('isActive', true)->latest()->limit(3)->get();

        view()->share('global_social', $socials);
        view()->share('global_categories', $categories);
        view()->share('global_recent_articles', $articles);
        view()->share('global_tags', $tags);
        view()->share('global_setting',$settings);
        view()->share('global_famous',$famous_articles);
        view()->share('global_kiosk_issues', $kiosk_issues);
    }
}
