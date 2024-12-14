<?php

namespace App\Providers;

use App\Interface\RepositoryInterface\CategoryInterface\CategoryRepositoryInterface;
use App\Models\Category;
use App\Observers\CategoryObserver;
use App\Repositories\CategoryRepository\CategoryRepository;
use Illuminate\Support\ServiceProvider;

class CategoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
        //
    }
}
