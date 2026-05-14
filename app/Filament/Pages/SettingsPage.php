<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Cài đặt';

    protected static ?string $title = 'Cài đặt hệ thống';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.settings-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'google_oauth_client_id'     => Setting::get('google_oauth_client_id', ''),
            'google_oauth_client_secret' => Setting::get('google_oauth_client_secret', ''),
            'google_drive_folder_id'     => Setting::get('google_drive_folder_id', ''),
            'site_name'                  => Setting::get('site_name', 'HocLieuTieuHoc'),
            'site_description'           => Setting::get('site_description', ''),
            'site_keywords'              => Setting::get('site_keywords', ''),
            'site_url'                   => Setting::get('site_url', ''),
            'og_image_url'               => Setting::get('og_image_url', ''),
            'adsense_publisher_id'       => Setting::get('adsense_publisher_id', ''),
            'adsense_auto_ads'           => Setting::get('adsense_auto_ads', '0'),
            'ad_slot_header'             => Setting::get('ad_slot_header', ''),
            'ad_slot_sidebar'            => Setting::get('ad_slot_sidebar', ''),
            'ad_slot_in_content'         => Setting::get('ad_slot_in_content', ''),
            'ad_slot_footer'             => Setting::get('ad_slot_footer', ''),
            'analytics_head_code'        => Setting::get('analytics_head_code', ''),
            'footer_tagline'             => Setting::get('footer_tagline', 'Thư viện tài liệu giáo dục miễn phí dành cho học sinh Tiểu học. Hàng ngàn tài liệu chất lượng cao từ lớp Tiền tiểu học đến lớp 5.'),
            'footer_copyright'           => Setting::get('footer_copyright', ''),
            'footer_links'               => Setting::get('footer_links', ''),
            'navbar_logo_icon'           => Setting::get('navbar_logo_icon', 'fa-graduation-cap'),
            'navbar_logo_url'            => Setting::get('navbar_logo_url', ''),
            'navbar_logo_upload'         => null,
            'navbar_logo_size'           => (int) Setting::get('navbar_logo_size', 36),
            'navbar_show_site_name'      => (bool) Setting::get('navbar_show_site_name', true),
            'favicon_url'                => Setting::get('favicon_url', ''),
            'favicon_upload'             => null,
            'favicon_size'               => (int) Setting::get('favicon_size', 32),
            'footer_logo_url'            => Setting::get('footer_logo_url', ''),
            'footer_logo_upload'         => null,
            'footer_logo_sync'           => Setting::get('footer_logo_sync', '1') === '1',
            'navbar_bg_color'            => Setting::get('navbar_bg_color', '#ffffff'),
            'navbar_border_color'        => Setting::get('navbar_border_color', '#DFFF00'),
            'navbar_text_color'          => Setting::get('navbar_text_color', '#446800'),
            'footer_bg_color'            => Setting::get('footer_bg_color', '#2e4800'),
            'hero_mascot_url'            => Setting::get('hero_mascot_url', 'https://e7.pngegg.com/pngimages/68/965/png-clipart-library-thinking-cartoon-children-cartoon-character-template.png'),
            'hero_mascot_upload'         => null,
            'hero_mascot_size'           => (int) Setting::get('hero_mascot_size', 180),
            'hero_stat_docs'             => Setting::get('hero_stat_docs', '12,500+ tài liệu'),
            'hero_stat_downloads'        => Setting::get('hero_stat_downloads', '58,000+ lượt tải'),
            'hero_stat_free'             => Setting::get('hero_stat_free', 'Hoàn toàn miễn phí'),
            'hero_card1_subject'         => Setting::get('hero_card1_subject', 'PDF · Toán'),
            'hero_card1_title'           => Setting::get('hero_card1_title', "Đề kiểm tra Toán\nHọc kì 1 · Lớp 4"),
            'hero_card1_views'           => Setting::get('hero_card1_views', '2,400 lượt tải'),
            'hero_card2_subject'         => Setting::get('hero_card2_subject', 'PPTX · Tiếng Việt'),
            'hero_card2_title'           => Setting::get('hero_card2_title', "Bài giảng Tiếng Việt\nTuần 12 · Lớp 3"),
            'hero_card2_views'           => Setting::get('hero_card2_views', '1,800 lượt tải'),
            'hero_card3_subject'         => Setting::get('hero_card3_subject', 'DOCX · Tập viết'),
            'hero_card3_title'           => Setting::get('hero_card3_title', "Luyện viết chữ đẹp\nQuyển 1 · Lớp 1"),
            'hero_card3_views'           => Setting::get('hero_card3_views', '3,200 lượt tải'),
        ]);

        if (session('success')) {
            Notification::make()
                ->title(session('success'))
                ->success()
                ->send();
        }

        if (session('error')) {
            Notification::make()
                ->title(session('error'))
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Google Drive API')
                    ->schema([
                        Forms\Components\TextInput::make('google_oauth_client_id')
                            ->label('OAuth Client ID')
                            ->maxLength(300),

                        Forms\Components\TextInput::make('google_oauth_client_secret')
                            ->label('OAuth Client Secret')
                            ->password()
                            ->revealable()
                            ->maxLength(300),

                        Forms\Components\TextInput::make('google_drive_folder_id')
                            ->label('Google Drive Folder ID')
                            ->helperText('ID thư mục Google Drive để lưu tài liệu')
                            ->maxLength(200),
                    ])->columns(1),

                Forms\Components\Section::make('Thông tin & SEO cơ bản')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Tên trang web')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('site_url')
                            ->label('URL trang web (có https://)')
                            ->url()
                            ->placeholder('https://hoclieu.vn')
                            ->maxLength(200),

                        Forms\Components\Textarea::make('site_description')
                            ->label('Mô tả trang web (meta description mặc định)')
                            ->rows(2)
                            ->maxLength(160)
                            ->helperText('Tối đa 160 ký tự — hiện trong kết quả tìm kiếm Google'),

                        Forms\Components\TextInput::make('site_keywords')
                            ->label('Từ khoá SEO (meta keywords, cách nhau bằng dấu phẩy)')
                            ->placeholder('tài liệu tiểu học, đề kiểm tra toán, luyện viết')
                            ->maxLength(300),

                        Forms\Components\TextInput::make('og_image_url')
                            ->label('Ảnh mặc định khi chia sẻ mạng xã hội (OG Image URL)')
                            ->url()
                            ->placeholder('https://hoclieu.vn/og-image.jpg')
                            ->helperText('Kích thước khuyến nghị: 1200×630px')
                            ->maxLength(500),
                    ])->columns(1),

                Forms\Components\Section::make('Google AdSense')
                    ->description('Để trống nếu chưa có AdSense. Publisher ID có dạng: ca-pub-XXXXXXXXXXXXXXXX')
                    ->schema([
                        Forms\Components\TextInput::make('adsense_publisher_id')
                            ->label('Publisher ID')
                            ->placeholder('ca-pub-XXXXXXXXXXXXXXXX')
                            ->maxLength(50),

                        Forms\Components\Toggle::make('adsense_auto_ads')
                            ->label('Bật Auto Ads (Google tự đặt quảng cáo)')
                            ->helperText('Nếu bật, Google tự chọn vị trí quảng cáo — không cần điền Ad Slot bên dưới'),

                        Forms\Components\Textarea::make('ad_slot_header')
                            ->label('Quảng cáo đầu trang (dưới header)')
                            ->rows(3)
                            ->placeholder('<ins class="adsbygoogle" ...')
                            ->helperText('Dán code <ins> từ AdSense vào đây'),

                        Forms\Components\Textarea::make('ad_slot_sidebar')
                            ->label('Quảng cáo sidebar (trang tìm kiếm / tài liệu)')
                            ->rows(3)
                            ->placeholder('<ins class="adsbygoogle" ...'),

                        Forms\Components\Textarea::make('ad_slot_in_content')
                            ->label('Quảng cáo trong nội dung (trang chi tiết tài liệu)')
                            ->rows(3)
                            ->placeholder('<ins class="adsbygoogle" ...'),

                        Forms\Components\Textarea::make('ad_slot_footer')
                            ->label('Quảng cáo cuối trang (trên footer)')
                            ->rows(3)
                            ->placeholder('<ins class="adsbygoogle" ...'),
                    ])->columns(1)->collapsed(),

                Forms\Components\Section::make('Hero Section')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_mascot_upload')
                            ->label('Upload ảnh mascot (PNG/JPG/WebP)')
                            ->image()
                            ->disk('public')
                            ->directory('mascot')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/gif'])
                            ->maxSize(2048)
                            ->helperText('Upload ảnh lên server. Sau khi lưu sẽ tự cập nhật URL bên dưới.')
                            ->imagePreviewHeight('120'),

                        Forms\Components\TextInput::make('hero_mascot_url')
                            ->label('Hoặc nhập URL ảnh mascot trực tiếp')
                            ->placeholder('https://...')
                            ->helperText('Nếu upload ảnh ở trên, URL sẽ tự điền. Có thể nhập URL ngoài tùy ý.'),

                        Forms\Components\TextInput::make('hero_mascot_size')
                            ->label('Kích cỡ mascot (px)')
                            ->type('range')
                            ->helperText('Kéo hoặc nhập giá trị từ 80 đến 400px (mặc định: 180px)')
                            ->extraInputAttributes(['min' => '80', 'max' => '400', 'step' => '10', 'style' => 'width:100%;accent-color:#84cc16;cursor:pointer']),

                        Forms\Components\TextInput::make('hero_stat_docs')
                            ->label('Thống kê 1 — Số tài liệu')
                            ->placeholder('12,500+ tài liệu')
                            ->maxLength(50),

                        Forms\Components\TextInput::make('hero_stat_downloads')
                            ->label('Thống kê 2 — Lượt tải')
                            ->placeholder('58,000+ lượt tải')
                            ->maxLength(50),

                        Forms\Components\TextInput::make('hero_stat_free')
                            ->label('Thống kê 3 — Tag miễn phí')
                            ->placeholder('Hoàn toàn miễn phí')
                            ->maxLength(50),

                        Forms\Components\Fieldset::make('Thẻ nổi 1 (đỏ — PDF)')
                            ->schema([
                                Forms\Components\TextInput::make('hero_card1_subject')
                                    ->label('Nhãn loại · Môn (dòng nhỏ)')
                                    ->placeholder('PDF · Toán')
                                    ->maxLength(50),
                                Forms\Components\Textarea::make('hero_card1_title')
                                    ->label('Tiêu đề (xuống dòng = \\n)')
                                    ->rows(2)
                                    ->placeholder("Đề kiểm tra Toán\nHọc kì 1 · Lớp 4"),
                                Forms\Components\TextInput::make('hero_card1_views')
                                    ->label('Lượt tải')
                                    ->placeholder('2,400 lượt tải')
                                    ->maxLength(30),
                            ])->columns(1),

                        Forms\Components\Fieldset::make('Thẻ nổi 2 (cam — PPT)')
                            ->schema([
                                Forms\Components\TextInput::make('hero_card2_subject')
                                    ->label('Nhãn loại · Môn (dòng nhỏ)')
                                    ->placeholder('PPTX · Tiếng Việt')
                                    ->maxLength(50),
                                Forms\Components\Textarea::make('hero_card2_title')
                                    ->label('Tiêu đề (xuống dòng = \\n)')
                                    ->rows(2)
                                    ->placeholder("Bài giảng Tiếng Việt\nTuần 12 · Lớp 3"),
                                Forms\Components\TextInput::make('hero_card2_views')
                                    ->label('Lượt tải')
                                    ->placeholder('1,800 lượt tải')
                                    ->maxLength(30),
                            ])->columns(1),

                        Forms\Components\Fieldset::make('Thẻ nổi 3 (xanh — DOC)')
                            ->schema([
                                Forms\Components\TextInput::make('hero_card3_subject')
                                    ->label('Nhãn loại · Môn (dòng nhỏ)')
                                    ->placeholder('DOCX · Tập viết')
                                    ->maxLength(50),
                                Forms\Components\Textarea::make('hero_card3_title')
                                    ->label('Tiêu đề (xuống dòng = \\n)')
                                    ->rows(2)
                                    ->placeholder("Luyện viết chữ đẹp\nQuyển 1 · Lớp 1"),
                                Forms\Components\TextInput::make('hero_card3_views')
                                    ->label('Lượt tải')
                                    ->placeholder('3,200 lượt tải')
                                    ->maxLength(30),
                            ])->columns(1),
                    ])->columns(1),

                Forms\Components\Section::make('Mã theo dõi / Analytics')
                    ->description('Google Analytics, Facebook Pixel, Google Tag Manager, v.v.')
                    ->schema([
                        Forms\Components\Textarea::make('analytics_head_code')
                            ->label('Mã chèn vào <head> (GA4, GTM, v.v.)')
                            ->rows(4)
                            ->placeholder("<!-- Google tag (gtag.js) -->\n<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX\"></script>\n...")
                            ->helperText('Dán nguyên block script từ Google Analytics / GTM vào đây'),
                    ])->columns(1)->collapsed(),

                Forms\Components\Section::make('Navbar (thanh điều hướng)')
                    ->schema([
                        Forms\Components\FileUpload::make('navbar_logo_upload')
                            ->label('Upload logo (PNG/JPG/SVG/WebP — tối đa 5MB)')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                            ->maxSize(5120)
                            ->imagePreviewHeight('60')
                            ->helperText('Nếu upload, logo ảnh sẽ thay thế icon Font Awesome. Để trống giữ nguyên icon.'),

                        Forms\Components\TextInput::make('navbar_logo_url')
                            ->label('Hoặc nhập URL logo trực tiếp')
                            ->placeholder('https://...')
                            ->maxLength(500),

                        Forms\Components\Placeholder::make('navbar_logo_preview')
                            ->label('Logo hiện tại')
                            ->content(function () {
                                $url = Setting::get('navbar_logo_url', '');
                                if (!$url) return new \Illuminate\Support\HtmlString('<span class="text-gray-400 text-sm">Chưa có logo — đang dùng icon Font Awesome</span>');
                                $filename = basename(parse_url($url, PHP_URL_PATH));
                                return new \Illuminate\Support\HtmlString('<div class="flex items-center gap-3"><img src="'.e($url).'" style="height:48px;width:auto;object-fit:contain;border:1px solid #e5e7eb;border-radius:6px;padding:4px;background:#f9fafb" onerror="this.style.display=\'none\'"><span class="text-xs text-gray-500">'.e($filename).'</span></div>');
                            }),

                        Forms\Components\TextInput::make('navbar_logo_size')
                            ->label('Kích cỡ logo (px)')
                            ->type('range')
                            ->helperText('Chiều cao logo, từ 20 đến 120px (mặc định: 36px)')
                            ->extraInputAttributes(['min' => '20', 'max' => '120', 'step' => '2', 'style' => 'width:100%;accent-color:#84cc16;cursor:pointer']),

                        Forms\Components\Toggle::make('navbar_show_site_name')
                            ->label('Hiển thị tên trang web kế bên logo')
                            ->helperText('Bật: tên trang luôn hiện. Tắt: chỉ hiện ảnh logo (hoặc icon nếu chưa upload).')
                            ->default(true),

                        Forms\Components\FileUpload::make('favicon_upload')
                            ->label('Upload favicon (ICO/PNG — tối đa 5MB)')
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/x-icon', 'image/png', 'image/svg+xml'])
                            ->maxSize(5120)
                            ->helperText('Khuyến nghị 32×32px hoặc 16×16px. Sau khi lưu sẽ hiển thị trên tab trình duyệt.'),

                        Forms\Components\TextInput::make('favicon_url')
                            ->label('Hoặc nhập URL favicon trực tiếp')
                            ->placeholder('https://...')
                            ->maxLength(500),

                        Forms\Components\TextInput::make('favicon_size')
                            ->label('Kích cỡ favicon (px)')
                            ->type('range')
                            ->helperText('Thường là 16 hoặc 32px (mặc định: 32px)')
                            ->extraInputAttributes(['min' => '8', 'max' => '64', 'step' => '2', 'style' => 'width:100%;accent-color:#84cc16;cursor:pointer']),

                        Forms\Components\TextInput::make('navbar_logo_icon')
                            ->label('Icon logo Font Awesome (dùng khi không có ảnh)')
                            ->placeholder('fa-graduation-cap')
                            ->helperText('Ví dụ: fa-graduation-cap, fa-book-open, fa-school')
                            ->maxLength(50),

                        Forms\Components\ColorPicker::make('navbar_bg_color')
                            ->label('Màu nền navbar'),

                        Forms\Components\ColorPicker::make('navbar_border_color')
                            ->label('Màu viền dưới navbar'),

                        Forms\Components\ColorPicker::make('navbar_text_color')
                            ->label('Màu chữ tên logo'),
                    ])->columns(2),

                Forms\Components\Section::make('Footer')
                    ->schema([
                        Forms\Components\Toggle::make('footer_logo_sync')
                            ->label('Sử dụng logo giống header')
                            ->helperText('Bật: dùng đúng logo và kích cỡ của header. Tắt: cài logo riêng cho footer.')
                            ->default(true)
                            ->reactive(),

                        Forms\Components\FileUpload::make('footer_logo_upload')
                            ->label('Upload logo footer riêng (PNG/JPG/SVG/WebP)')
                            ->image()
                            ->disk('public')
                            ->directory('branding')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'])
                            ->maxSize(5120)
                            ->imagePreviewHeight('60')
                            ->helperText('Chỉ dùng khi đã tắt đồng bộ trên. Nếu để trống sử dụng logo đang có.')
                            ->visible(fn ($get) => !$get('footer_logo_sync')),

                        Forms\Components\TextInput::make('footer_logo_url')
                            ->label('Hoặc nhập URL logo footer trực tiếp')
                            ->placeholder('https://...')
                            ->maxLength(500)
                            ->visible(fn ($get) => !$get('footer_logo_sync')),

                        Forms\Components\Placeholder::make('footer_logo_preview')
                            ->label('Logo footer hiện tại')
                            ->content(function () {
                                $sync = Setting::get('footer_logo_sync', '1') === '1';
                                $url = $sync ? Setting::get('navbar_logo_url', '') : Setting::get('footer_logo_url', '');
                                if (!$url) return new \Illuminate\Support\HtmlString('<span class="text-gray-400 text-sm">' . ($sync ? 'Đồng bộ với header — chưa có logo' : 'Chưa có logo footer') . '</span>');
                                $filename = basename(parse_url($url, PHP_URL_PATH));
                                return new \Illuminate\Support\HtmlString('<div class="flex items-center gap-3"><img src="'.e($url).'" style="height:48px;width:auto;object-fit:contain;border:1px solid #e5e7eb;border-radius:6px;padding:4px;background:#1a2e00" onerror="this.style.display=\'none\'"><span class="text-xs text-gray-500">'.e($filename) . ($sync ? ' (từ header)' : '') .'</span></div>');
                            })
                            ->visible(fn ($get) => !$get('footer_logo_sync')),

                        Forms\Components\TextInput::make('footer_logo_size')
                            ->label('Kích cỡ logo footer (px)')
                            ->type('range')
                            ->helperText('Chiều cao logo footer, từ 20 đến 120px (mặc định: 36px)')
                            ->extraInputAttributes(['min' => '20', 'max' => '120', 'step' => '2', 'style' => 'width:100%;accent-color:#84cc16;cursor:pointer'])
                            ->visible(fn ($get) => !$get('footer_logo_sync')),

                        Forms\Components\Textarea::make('footer_tagline')
                            ->label('Mô tả ngắn dưới logo')
                            ->rows(2)
                            ->maxLength(200),

                        Forms\Components\TextInput::make('footer_copyright')
                            ->label('Dòng copyright (để trống = dùng tên trang web)')
                            ->placeholder('© 2025 HocLieuTieuHoc. Tất cả quyền được bảo lưu.')
                            ->maxLength(200),

                        Forms\Components\TextInput::make('footer_links')
                            ->label('Liên kết phụ (cách nhau bằng |, dạng: Tên,/url|Tên2,/url2)')
                            ->placeholder('Trang chủ,/|Tìm kiếm,/search|Quản trị,/admin')
                            ->helperText('Mỗi liên kết: Tên,/đường-dẫn — cách nhau bằng dấu |')
                            ->maxLength(500),

                        Forms\Components\ColorPicker::make('footer_bg_color')
                            ->label('Màu nền footer'),
                    ])->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('google_oauth_client_id', $data['google_oauth_client_id'] ?? '');
        Setting::set('google_drive_folder_id', $data['google_drive_folder_id'] ?? '');
        Setting::set('site_name', $data['site_name'] ?? 'HocLieuTieuHoc');
        Setting::set('navbar_logo_icon', $data['navbar_logo_icon'] ?? 'fa-graduation-cap');

        // Logo upload
        if (!empty($data['navbar_logo_upload'])) {
            $path = is_array($data['navbar_logo_upload']) ? array_values($data['navbar_logo_upload'])[0] : $data['navbar_logo_upload'];
            Setting::set('navbar_logo_url', \Illuminate\Support\Facades\Storage::disk('public')->url($path));
        } else {
            Setting::set('navbar_logo_url', $data['navbar_logo_url'] ?? '');
        }
        Setting::set('navbar_logo_size', $data['navbar_logo_size'] ?? 36);
        Setting::set('navbar_show_site_name', isset($data['navbar_show_site_name']) ? (bool)$data['navbar_show_site_name'] : true);

        // Footer logo
        $footerSync = isset($data['footer_logo_sync']) ? (bool)$data['footer_logo_sync'] : true;
        Setting::set('footer_logo_sync', $footerSync ? '1' : '0');
        if (!$footerSync) {
            if (!empty($data['footer_logo_upload'])) {
                $path = is_array($data['footer_logo_upload']) ? array_values($data['footer_logo_upload'])[0] : $data['footer_logo_upload'];
                Setting::set('footer_logo_url', \Illuminate\Support\Facades\Storage::disk('public')->url($path));
            } else {
                Setting::set('footer_logo_url', $data['footer_logo_url'] ?? '');
            }
            Setting::set('footer_logo_size', $data['footer_logo_size'] ?? 36);
        }

        // Favicon upload
        if (!empty($data['favicon_upload'])) {
            $path = is_array($data['favicon_upload']) ? array_values($data['favicon_upload'])[0] : $data['favicon_upload'];
            Setting::set('favicon_url', \Illuminate\Support\Facades\Storage::disk('public')->url($path));
        } else {
            Setting::set('favicon_url', $data['favicon_url'] ?? '');
        }
        Setting::set('favicon_size', $data['favicon_size'] ?? 32);
        Setting::set('navbar_bg_color', $data['navbar_bg_color'] ?? '#ffffff');
        Setting::set('navbar_border_color', $data['navbar_border_color'] ?? '#DFFF00');
        Setting::set('navbar_text_color', $data['navbar_text_color'] ?? '#446800');
        Setting::set('footer_tagline', $data['footer_tagline'] ?? '');
        Setting::set('footer_copyright', $data['footer_copyright'] ?? '');
        Setting::set('footer_links', $data['footer_links'] ?? '');
        Setting::set('footer_bg_color', $data['footer_bg_color'] ?? '#2e4800');
        Setting::set('site_url', $data['site_url'] ?? '');
        Setting::set('site_description', $data['site_description'] ?? '');
        Setting::set('site_keywords', $data['site_keywords'] ?? '');
        Setting::set('og_image_url', $data['og_image_url'] ?? '');
        Setting::set('adsense_publisher_id', $data['adsense_publisher_id'] ?? '');
        Setting::set('adsense_auto_ads', $data['adsense_auto_ads'] ? '1' : '0');
        Setting::set('ad_slot_header', $data['ad_slot_header'] ?? '');
        Setting::set('ad_slot_sidebar', $data['ad_slot_sidebar'] ?? '');
        Setting::set('ad_slot_in_content', $data['ad_slot_in_content'] ?? '');
        Setting::set('ad_slot_footer', $data['ad_slot_footer'] ?? '');
        Setting::set('analytics_head_code', $data['analytics_head_code'] ?? '');
        Setting::set('hero_stat_docs', $data['hero_stat_docs'] ?? '12,500+ tài liệu');
        Setting::set('hero_mascot_size', $data['hero_mascot_size'] ?? 180);
        Setting::set('hero_stat_downloads', $data['hero_stat_downloads'] ?? '58,000+ lượt tải');
        Setting::set('hero_stat_free', $data['hero_stat_free'] ?? 'Hoàn toàn miễn phí');
        Setting::set('hero_card1_subject', $data['hero_card1_subject'] ?? 'PDF · Toán');
        Setting::set('hero_card1_title', $data['hero_card1_title'] ?? "Đề kiểm tra Toán\nHọc kì 1 · Lớp 4");
        Setting::set('hero_card1_views', $data['hero_card1_views'] ?? '2,400 lượt tải');
        Setting::set('hero_card2_subject', $data['hero_card2_subject'] ?? 'PPTX · Tiếng Việt');
        Setting::set('hero_card2_title', $data['hero_card2_title'] ?? "Bài giảng Tiếng Việt\nTuần 12 · Lớp 3");
        Setting::set('hero_card2_views', $data['hero_card2_views'] ?? '1,800 lượt tải');
        Setting::set('hero_card3_subject', $data['hero_card3_subject'] ?? 'DOCX · Tập viết');
        Setting::set('hero_card3_title', $data['hero_card3_title'] ?? "Luyện viết chữ đẹp\nQuyển 1 · Lớp 1");
        Setting::set('hero_card3_views', $data['hero_card3_views'] ?? '3,200 lượt tải');

        // If a file was uploaded, convert to public URL and override the URL field
        if (!empty($data['hero_mascot_upload'])) {
            $uploadedPath = is_array($data['hero_mascot_upload'])
                ? array_values($data['hero_mascot_upload'])[0]
                : $data['hero_mascot_upload'];
            Setting::set('hero_mascot_url', \Illuminate\Support\Facades\Storage::disk('public')->url($uploadedPath));
        } else {
            Setting::set('hero_mascot_url', $data['hero_mascot_url'] ?? '');
        }

        // Only update secret if provided (not empty)
        if (! empty($data['google_oauth_client_secret'])) {
            Setting::set('google_oauth_client_secret', $data['google_oauth_client_secret']);
        }

        \App\Models\Setting::clearCache();
        \Illuminate\Support\Facades\Cache::forget('app_settings');

        Notification::make()
            ->title('Đã lưu cài đặt')
            ->success()
            ->send();
    }

    public function isGoogleDriveConnected(): bool
    {
        return ! empty(Setting::get('google_oauth_refresh_token', ''));
    }

    public function disconnectGoogleDrive(): void
    {
        Setting::set('google_oauth_refresh_token', '');
        \App\Models\Setting::clearCache();

        Notification::make()
            ->title('Đã ngắt kết nối Google Drive')
            ->warning()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Lưu cài đặt')
                ->submit('save'),
        ];
    }
}
