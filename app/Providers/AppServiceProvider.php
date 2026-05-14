<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GoogleDriveService::class, function ($app) {
            return new GoogleDriveService();
        });
    }

    public function boot(): void
    {
        config()->set('livewire.temporary_file_upload.rules', ['required', 'file', 'max:1048576']);
        config()->set('livewire.temporary_file_upload.max_upload_time', 120);

        // Share nav categories to all views — cached 60 min
        View::composer('*', function ($view) {
            $navCategories = Cache::remember('nav_categories', 3600, function () {
                return Category::whereNull('parent_id')
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get();
            });
            $view->with('navCategories', $navCategories);
        });
    }
}
