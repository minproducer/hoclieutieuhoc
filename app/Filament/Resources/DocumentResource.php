<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Category;
use App\Models\Document;
use App\Services\GoogleDriveService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Tài liệu';

    protected static ?string $modelLabel = 'Tài liệu';

    protected static ?string $pluralModelLabel = 'Tài liệu';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    protected static int $globalSearchResultsLimit = 10;

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Môn học' => $record->category?->name,
            'Loại'   => strtoupper($record->file_type),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin cơ bản')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Tiêu đề')
                            ->required()
                            ->maxLength(500)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state, ?string $operation) {
                                if ($operation === 'create' && $state) {
                                    $set('slug', Str::slug($state));
                                    $set('meta_title', $state);
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(500)
                            ->unique(Document::class, 'slug', ignoreRecord: true),

                        Forms\Components\Textarea::make('description')
                            ->label('Mô tả ngắn')
                            ->rows(3)
                            ->maxLength(1000),

                        Forms\Components\RichEditor::make('content')
                            ->label('Nội dung chi tiết')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public'),
                    ])->columns(2),

                Forms\Components\Section::make('Phân loại')
                    ->schema([
                        Forms\Components\Select::make('grade_level')
                            ->label('Khối lớp')
                            ->options([
                                0 => 'Tiền Tiểu học',
                                1 => 'Lớp 1',
                                2 => 'Lớp 2',
                                3 => 'Lớp 3',
                                4 => 'Lớp 4',
                                5 => 'Lớp 5',
                            ])
                            ->nullable()
                            ->placeholder('Chọn khối lớp')
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('category_id', null)),

                        Forms\Components\Select::make('category_id')
                            ->label('Phân loại (Môn - Dạng bài)')
                            ->options(function (Forms\Get $get) {
                                $gradeLevel = $get('grade_level');

                                if ($gradeLevel === null || $gradeLevel === '') {
                                    // No grade selected — show all sub-categories grouped
                                    return Category::whereNotNull('parent_id')
                                        ->with('parent')
                                        ->get()
                                        ->groupBy(fn ($c) => $c->parent?->name ?? 'Khác')
                                        ->map(fn ($group) => $group->pluck('name', 'id'))
                                        ->toArray();
                                }

                                // Find parent category matching grade_level
                                $gradeLevel = (int) $gradeLevel;
                                $parentName = $gradeLevel === 0 ? 'Tiền tiểu học' : "Lớp {$gradeLevel}";
                                $parent = Category::whereNull('parent_id')
                                    ->where('name', $parentName)
                                    ->first();

                                if (! $parent) {
                                    return [];
                                }

                                return Category::where('parent_id', $parent->id)
                                    ->ordered()
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->nullable()
                            ->placeholder('Chọn phân loại')
                            ->helperText(fn (Forms\Get $get) => $get('grade_level') === null
                                ? 'Hãy chọn Khối lớp trước để lọc danh sách'
                                : null
                            ),

                        Forms\Components\Select::make('file_type')
                            ->label('Loại tệp')
                            ->options([
                                'pdf'   => 'PDF',
                                'docx'  => 'Word (DOCX)',
                                'pptx'  => 'PowerPoint (PPTX)',
                                'xlsx'  => 'Excel (XLSX)',
                                'zip'   => 'ZIP / RAR',
                                'image' => 'Hình ảnh',
                            ])
                            ->default('pdf')
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'draft'     => 'Nháp',
                                'published' => 'Đã đăng',
                                'hidden'    => 'Ẩn',
                            ])
                            ->default('draft')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Cài đặt hiển thị')
                    ->schema([
                        Forms\Components\Toggle::make('is_public')
                            ->label('Công khai')
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Nổi bật')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Upload lên Google Drive')
                    ->schema([
                        Forms\Components\FileUpload::make('upload_file')
                            ->label('Chọn tệp để tải lên')
                            ->storeFiles(false)
                            ->helperText(function ($record) {
                                if ($record && filled($record->drive_file_id)) {
                                    return 'Đã có file trên Drive. Upload file mới sẽ tự động xóa file cũ và thay thế.';
                                }
                                return 'Hỗ trợ: PDF, Word, PowerPoint, Excel, ZIP. Sau khi lưu, tệp sẽ được upload lên Google Drive tự động.';
                            }),

                        Forms\Components\TextInput::make('drive_file_id')
                            ->label('Google Drive File ID')
                            ->readOnly()
                            ->maxLength(200),

                        Forms\Components\TextInput::make('drive_view_link')
                            ->label('Drive View Link')
                            ->readOnly()
                            ->url()
                            ->maxLength(500),

                        Forms\Components\TextInput::make('file_size_kb')
                            ->label('Kích thước (KB)')
                            ->numeric()
                            ->readOnly(),

                        Forms\Components\TextInput::make('page_count')
                            ->label('Số trang')
                            ->numeric(),
                    ])->columns(2),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(200),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(2)
                            ->maxLength(300),

                        Forms\Components\FileUpload::make('thumbnail_url')
                            ->label('Ảnh thumbnail')
                            ->image()
                            ->disk('public')
                            ->directory('thumbnails')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(10240)
                            ->helperText('Nếu không upload thumbnail, hệ thống sẽ tự dùng ảnh preview đầu tiên từ file Google Drive.'),
                    ])->columns(1)->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable()
                    ->limit(60)
                    ->wrap(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Môn học')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\BadgeColumn::make('file_type')
                    ->label('Loại')
                    ->colors([
                        'danger'  => 'pdf',
                        'info'    => 'docx',
                        'warning' => 'pptx',
                        'success' => 'xlsx',
                        'purple'  => 'zip',
                        'pink'    => 'image',
                    ])
                    ->formatStateUsing(fn ($state) => strtoupper($state)),

                Tables\Columns\TextColumn::make('grade_level')
                    ->label('Lớp')
                    ->formatStateUsing(fn ($state) => match((int) $state) {
                        0       => 'Tiền TH',
                        1, 2, 3, 4, 5 => "Lớp {$state}",
                        default => '—',
                    })
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->colors([
                        'gray'    => 'draft',
                        'success' => 'published',
                        'danger'  => 'hidden',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'draft'     => 'Nháp',
                        'published' => 'Đã đăng',
                        'hidden'    => 'Ẩn',
                        default     => $state,
                    }),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Nổi bật')
                    ->boolean(),

                Tables\Columns\TextColumn::make('view_count')
                    ->label('Lượt xem')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('download_count')
                    ->label('Tải xuống')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'draft'     => 'Nháp',
                        'published' => 'Đã đăng',
                        'hidden'    => 'Ẩn',
                    ]),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Phân loại')
                    ->options(
                        Category::whereNotNull('parent_id')
                            ->with('parent')
                            ->get()
                            ->groupBy(fn ($c) => $c->parent?->name ?? 'Khác')
                            ->map(fn ($group) => $group->pluck('name', 'id'))
                            ->toArray()
                    )
                    ->searchable(),

                Tables\Filters\SelectFilter::make('file_type')
                    ->label('Loại tệp')
                    ->options([
                        'pdf'   => 'PDF',
                        'docx'  => 'DOCX',
                        'pptx'  => 'PPTX',
                        'xlsx'  => 'XLSX',
                        'zip'   => 'ZIP',
                        'image' => 'Hình ảnh',
                    ]),

                Tables\Filters\SelectFilter::make('grade_level')
                    ->label('Khối lớp')
                    ->options([
                        0 => 'Tiền Tiểu học',
                        1 => 'Lớp 1',
                        2 => 'Lớp 2',
                        3 => 'Lớp 3',
                        4 => 'Lớp 4',
                        5 => 'Lớp 5',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view_frontend')
                    ->label('Xem ngoài')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn (Document $record) => route('document.show', $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit'   => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
