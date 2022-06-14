<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Contracts\Dao\StudentDaoInterface', 'App\Dao\StudentDao');
        $this->app->bind('App\Contracts\Dao\TeacherDaoInterface', 'App\Dao\TeacherDao');
        $this->app->bind('App\Contracts\Dao\CourseDaoInterface', 'App\Dao\CourseDao');
        $this->app->bind('App\Contracts\Dao\AuthDaoInterface', 'App\Dao\AuthDao');
        $this->app->bind('App\Contracts\Services\StudentServiceInterface', 'App\Services\StudentService');
        $this->app->bind('App\Contracts\Services\TeacherServiceInterface', 'App\Services\TeacherService');
        $this->app->bind('App\Contracts\Services\CourseServiceInterface', 'App\Services\CourseService');
        $this->app->bind('App\Contracts\Services\AuthServiceInterface', 'App\Services\AuthService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
    }
}
