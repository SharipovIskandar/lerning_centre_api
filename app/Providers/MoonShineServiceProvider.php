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
            ])
            ->pages([
                ...$config->getPages(),
            ])
        ;
    }
}
