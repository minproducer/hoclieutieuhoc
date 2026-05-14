<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class GradeResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Khối lớp';

    protected static ?string $modelLabel = 'Khối lớp';

    protected static ?string $pluralModelLabel = 'Khối lớp';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'grades';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'grade');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Hidden::make('type')
                            ->default('grade'),

                        Forms\Components\TextInput::make('name')
                            ->label('Tên khối lớp')
                            ->required()
                            ->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state, ?string $operation) {
                                if ($operation === 'create' && $state) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(200)
                            ->unique(Category::class, 'slug', ignoreRecord: true),

                        Forms\Components\TextInput::make('icon')
                            ->label('Icon (Font Awesome class)')
                            ->placeholder('fa-1')
                            ->helperText('Ví dụ: fa-1, fa-2, fa-3...')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Thứ tự sắp xếp')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên khối lớp')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),

                Tables\Columns\TextColumn::make('children_count')
                    ->label('Số môn học')
                    ->counts('children')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit'   => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}
