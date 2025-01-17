<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When};
use App\MoonShine\Resources\ManageUsersResource;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\StudentResource;
use App\MoonShine\Resources\TeacherResource;
use App\MoonShine\Resources\AdminResource;
use App\MoonShine\Resources\TestResource;
use App\MoonShine\Resources\PaymentResource;
use App\MoonShine\Resources\RoomResource;
use App\MoonShine\Resources\ScheduleResource;
use App\MoonShine\Resources\CourseResource;
use App\MoonShine\Resources\ExamResultResource;
use App\MoonShine\Resources\ExamResource;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make('Payments', PaymentResource::class)->icon('banknotes'),
            MenuItem::make('Rooms', RoomResource::class)->icon('c.arrow-left-end-on-rectangle'),
            MenuItem::make('Schedules', ScheduleResource::class)->icon('table-cells'),
            MenuItem::make('Courses', CourseResource::class)->icon('m.book-open'),
            MenuItem::make('ExamResults', ExamResultResource::class)->icon('m.presentation-chart-line'),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
