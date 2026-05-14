<?php

namespace App\Filament\Pages;

use App\Models\Category;
use App\Models\Document;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\RecentDocumentsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Bảng điều khiển';

    protected static ?string $title = 'Bảng điều khiển';

    protected static ?int $navigationSort = 0;

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            RecentDocumentsWidget::class,
        ];
    }
}
