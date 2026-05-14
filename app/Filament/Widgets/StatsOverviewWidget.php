<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Document;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalDocs      = Document::where('status', 'published')->count();
        $totalViews     = Document::where('status', 'published')->sum('view_count');
        $totalDownloads = Document::where('status', 'published')->sum('download_count');
        $totalCategories = Category::count();

        return [
            Stat::make('Tài liệu đã đăng', number_format($totalDocs))
                ->description('Tổng số tài liệu công khai')
                ->icon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Lượt xem', number_format($totalViews))
                ->description('Tổng lượt xem tất cả tài liệu')
                ->icon('heroicon-o-eye')
                ->color('info'),

            Stat::make('Lượt tải xuống', number_format($totalDownloads))
                ->description('Tổng lượt tải xuống')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),

            Stat::make('Môn học', number_format($totalCategories))
                ->description('Số danh mục môn học')
                ->icon('heroicon-o-folder')
                ->color('warning'),
        ];
    }
}
