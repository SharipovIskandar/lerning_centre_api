<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Resources\AdminResource;
use App\MoonShine\Resources\StudentResource;
use App\MoonShine\Resources\TeacherResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\PaymentResource;
use App\MoonShine\Resources\RoomResource;
use App\MoonShine\Resources\ScheduleResource;
use App\MoonShine\Resources\CourseResource;
use App\MoonShine\Resources\ExamResultResource;
use App\MoonShine\Resources\ExamResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();

        $core
            ->resources([
                AdminResource::class,
                StudentResource::class,
                TeacherResource::class,
                PaymentResource::class,
                RoomResource::class,
                ScheduleResource::class,
                CourseResource::class,
                ExamResultResource::class,
                ExamResource::class,
            ])
            ->pages([
                ...$config->getPages(),
            ])
        ;
    }
}
