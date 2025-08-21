<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())->description('New users that have joined.')
                ->descriptionIcon('heroicon-o-user-group', IconPosition::Before)->color('danger')
                ->chart([1, 3, 5, 10, 20, 40]),

            Stat::make('Posts', Post::count())->description('Total website posts.')
                ->descriptionIcon('heroicon-o-newspaper', IconPosition::Before)->color('info')
                ->chart([1, 3, 5, 10, 20, 40]),
            Stat::make('Products Categories', Category::count())->description('Total product categories.')
                ->descriptionIcon('heroicon-o-clipboard', IconPosition::Before)->color('warning')
                ->chart([1, 3, 5, 10, 20, 40]),
        ];
    }
}
