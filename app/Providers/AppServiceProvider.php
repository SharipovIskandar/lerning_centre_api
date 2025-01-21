<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use App\Services\Attendance\AttendanceService;
use App\Services\Attendance\Contracts\iAttendanceService;
use App\Services\Homework\Contracts\iHomeworkEvaluationService;
use App\Services\Homework\Contracts\iHomeworkService;
use App\Services\Homework\HomeworkEvaluationService;
use App\Services\Homework\HomeworkService;
use App\Services\User\Contracts\iUserService;
use App\Services\User\UserService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(iUserService::class, UserService::class);
        $this->app->bind(
            iAttendanceService::class,
            AttendanceService::class
        );

        $this->app->bind(
            iHomeworkService::class,
            HomeworkService::class
        );

        $this->app->bind(
            iHomeworkEvaluationService::class,
            HomeworkEvaluationService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
    }
}
