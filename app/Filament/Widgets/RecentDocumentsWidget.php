<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentDocumentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Tài liệu mới nhất';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Document::with('category')
                    ->where('status', 'published')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->limit(60)
                    ->url(fn (Document $record) => route('document.show', $record->slug))
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Môn học')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\BadgeColumn::make('file_type')
                    ->label('Loại')
                    ->formatStateUsing(fn ($state) => strtoupper($state)),

                Tables\Columns\TextColumn::make('view_count')
                    ->label('Lượt xem')
                    ->numeric(),

                Tables\Columns\TextColumn::make('download_count')
                    ->label('Tải xuống')
                    ->numeric(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Đăng lúc')
                    ->since(),
            ])
            ->paginated(false);
    }
}
