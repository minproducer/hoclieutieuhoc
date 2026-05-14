<?php
    $siteName       = \App\Models\Setting::get('site_name', 'HocLieuTieuHoc');
    $siteUrl        = rtrim(\App\Models\Setting::get('site_url', config('app.url')), '/');
    $siteDesc       = \App\Models\Setting::get('site_description', 'Kho tài liệu giáo dục miễn phí cho học sinh Tiểu học Việt Nam');
    $siteKw         = \App\Models\Setting::get('site_keywords', 'tài liệu tiểu học, đề kiểm tra, đề ôn tập, luyện viết');
    $ogImage        = \App\Models\Setting::get('og_image_url', '');
    $adsensePub     = \App\Models\Setting::get('adsense_publisher_id', '');
    $adsenseAuto    = \App\Models\Setting::get('adsense_auto_ads', '0');
    $analyticsCode  = \App\Models\Setting::get('analytics_head_code', '');
    $navbarBg       = \App\Models\Setting::get('navbar_bg_color', '#ffffff');
    $navbarBorder   = \App\Models\Setting::get('navbar_border_color', '#DFFF00');
    $navbarTextColor= \App\Models\Setting::get('navbar_text_color', '#446800');
    $navbarIcon     = \App\Models\Setting::get('navbar_logo_icon', 'fa-graduation-cap');
    $navbarLogoUrl  = \App\Models\Setting::get('navbar_logo_url', '');
    $navbarLogoSize = (int) \App\Models\Setting::get('navbar_logo_size', 36);
    $navbarShowSiteName = (bool) \App\Models\Setting::get('navbar_show_site_name', true);
    $footerLogoSync = \App\Models\Setting::get('footer_logo_sync', '1') === '1';
    $footerLogoUrl  = $footerLogoSync ? $navbarLogoUrl : \App\Models\Setting::get('footer_logo_url', $navbarLogoUrl);
    $footerLogoSize = $footerLogoSync ? $navbarLogoSize : (int) \App\Models\Setting::get('footer_logo_size', $navbarLogoSize);
    $faviconUrl     = \App\Models\Setting::get('favicon_url', '');
    $faviconSize    = (int) \App\Models\Setting::get('favicon_size', 32);
    $footerBg       = \App\Models\Setting::get('footer_bg_color', '#2e4800');
    $footerTagline  = \App\Models\Setting::get('footer_tagline', 'Thư viện tài liệu giáo dục miễn phí dành cho học sinh Tiểu học. Hàng ngàn tài liệu chất lượng cao từ lớp Tiền tiểu học đến lớp 5.');
    $footerCopyright= \App\Models\Setting::get('footer_copyright', '');
    $footerLinksRaw = \App\Models\Setting::get('footer_links', '');
    $footerLinks    = array_filter(array_map(function($l) { return explode(',', trim($l), 2); }, explode('|', $footerLinksRaw)), function($p) { return count($p) === 2 && trim($p[0]) !== ''; });
    $pageTitle      = trim(strip_tags($__env->yieldContent('title', $siteName . ' - Thư viện tài liệu học tập')));
    $pageDesc       = trim(strip_tags($__env->yieldContent('description', $siteDesc)));
    $pageUrl        = $siteUrl . request()->getRequestUri();
?>
<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($faviconUrl): ?>
    <link rel="icon" href="<?php echo e($faviconUrl); ?>" sizes="<?php echo e($faviconSize); ?>x<?php echo e($faviconSize); ?>">
    <link rel="shortcut icon" href="<?php echo e($faviconUrl); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <title><?php echo e($pageTitle); ?></title>
    <meta name="description" content="<?php echo e(Str::limit($pageDesc, 160)); ?>">
    <meta name="keywords" content="<?php echo e($siteKw); ?>">
    <link rel="canonical" href="<?php echo e($pageUrl); ?>">

    
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e($siteName); ?>">
    <meta property="og:title" content="<?php echo e($pageTitle); ?>">
    <meta property="og:description" content="<?php echo e(Str::limit($pageDesc, 200)); ?>">
    <meta property="og:url" content="<?php echo e($pageUrl); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ogImage): ?><meta property="og:image" content="<?php echo e($ogImage); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo e(Str::limit($pageDesc, 200)); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ogImage): ?><meta name="twitter:image" content="<?php echo e($ogImage); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php echo $__env->yieldContent('meta'); ?>

    
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

    
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous" />
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css" crossorigin="anonymous" /></noscript>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous" />
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" crossorigin="anonymous" /></noscript>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet"></noscript>

    <style>
        :root {
            --color-primary: #7CB800;
            --color-accent: #DFFF00;
            --color-bg: #F8FFE0;
        }
        body {
            font-family: 'Nunito', 'Be Vietnam Pro', system-ui, sans-serif;
            background-color: var(--color-bg);
        }
        .badge-pdf    { background:#fee2e2; color:#b91c1c; }
        .badge-docx   { background:#dbeafe; color:#1d4ed8; }
        .badge-pptx   { background:#ffedd5; color:#c2410c; }
        .badge-xlsx   { background:#dcfce7; color:#15803d; }
        .badge-zip    { background:#ede9fe; color:#6d28d9; }
        .badge-image  { background:#fce7f3; color:#be185d; }
        .line-clamp-2 { overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
        .line-clamp-3 { overflow:hidden; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; }

        /* ===== LOADING SCREEN ===== */
        #page-loader {
            position: fixed; inset: 0; z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            background: linear-gradient(160deg, #f0fdf4 0%, #d9f99d 50%, #bbf7d0 100%);
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        #page-loader.hide {
            opacity: 0; visibility: hidden; pointer-events: none;
        }
        @keyframes tigerBounce {
            0%,100% { transform: translateY(0) rotate(-2deg); }
            50%      { transform: translateY(-18px) rotate(2deg); }
        }
        @keyframes tigerBlink {
            0%,90%,100% { transform: scaleY(1); }
            95%         { transform: scaleY(0.08); }
        }
        @keyframes tailWag {
            0%,100% { transform-origin: bottom left; transform: rotate(-15deg); }
            50%      { transform-origin: bottom left; transform: rotate(15deg); }
        }
        @keyframes dotPulse {
            0%,80%,100% { transform: scale(0.6); opacity: 0.4; }
            40%         { transform: scale(1.2); opacity: 1; }
        }
        @keyframes leafFloat {
            0%,100% { transform: translateY(0) rotate(0deg); opacity: 0.7; }
            50%      { transform: translateY(-12px) rotate(15deg); opacity: 1; }
        }
        .tiger-wrap { animation: tigerBounce 1.4s ease-in-out infinite; }
        #tiger-eye-l, #tiger-eye-r { animation: tigerBlink 3.5s ease-in-out infinite; transform-box: fill-box; transform-origin: center; }
        #tiger-tail { animation: tailWag 1.2s ease-in-out infinite; transform-box: fill-box; }
        .loader-dot { width:10px; height:10px; border-radius:50%; background:#4ade80; display:inline-block; margin:0 4px; animation: dotPulse 1.4s ease-in-out infinite; }
        .loader-dot:nth-child(2) { animation-delay: 0.2s; background:#84cc16; }
        .loader-dot:nth-child(3) { animation-delay: 0.4s; background:#a3e635; }
        .leaf { position:absolute; font-size:1.5rem; animation: leafFloat 2.5s ease-in-out infinite; }
        /* page transition flash */
        #page-loader.transition-flash { opacity:1 !important; visibility:visible !important; pointer-events:all !important; }
    </style>

    <?php echo $__env->yieldContent('head'); ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($analyticsCode): ?>
    <?php echo $analyticsCode; ?>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adsensePub): ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo e($adsensePub); ?>"
         crossorigin="anonymous"></script>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adsenseAuto === '1'): ?>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</head>
<body class="min-h-screen flex flex-col">

    
    <div id="page-loader" role="status" aria-label="Đang tải...">
        
        <span class="leaf" style="top:12%;left:10%;animation-delay:0s">&#127809;</span>
        <span class="leaf" style="top:18%;right:12%;animation-delay:0.8s">&#127807;</span>
        <span class="leaf" style="bottom:22%;left:8%;animation-delay:1.5s">&#127808;</span>
        <span class="leaf" style="bottom:18%;right:9%;animation-delay:0.4s">&#127809;</span>

        <div class="tiger-wrap" style="margin-bottom:12px;">
            <svg width="160" height="170" viewBox="0 0 160 170" xmlns="http://www.w3.org/2000/svg">
                
                <g id="tiger-tail">
                    <path d="M108 130 Q140 110 138 85 Q136 65 120 68" stroke="#F57F17" stroke-width="10" fill="none" stroke-linecap="round"/>
                    <circle cx="120" cy="65" r="10" fill="#FF8F00"/>
                    <circle cx="120" cy="65" r="6" fill="#FFF9C4"/>
                </g>
                
                <ellipse cx="80" cy="125" rx="38" ry="32" fill="#FFA726"/>
                <ellipse cx="80" cy="130" rx="22" ry="18" fill="#FFF8E1"/>
                
                <path d="M50 110 Q54 125 50 138" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                <path d="M110 110 Q106 125 110 138" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                
                <polygon points="42,42 28,14 56,26" fill="#FFA726"/>
                <polygon points="118,42 132,14 104,26" fill="#FFA726"/>
                <polygon points="44,40 32,18 55,28" fill="#FF8A80"/>
                <polygon points="116,40 128,18 105,28" fill="#FF8A80"/>
                
                <circle cx="80" cy="72" r="46" fill="#FFA726"/>
                
                <ellipse cx="80" cy="82" rx="28" ry="22" fill="#FFF8E1"/>
                
                <path d="M66 34 Q72 26 80 34" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                <path d="M56 42 Q60 34 66 40" stroke="#E65100" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                <path d="M94 40 Q100 34 104 42" stroke="#E65100" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                
                <circle cx="62" cy="66" r="13" fill="white"/>
                <circle cx="98" cy="66" r="13" fill="white"/>
                
                <g id="tiger-eye-l"><circle cx="63" cy="67" r="9" fill="#1a1a1a"/><circle cx="66" cy="64" r="3.5" fill="white"/></g>
                <g id="tiger-eye-r"><circle cx="99" cy="67" r="9" fill="#1a1a1a"/><circle cx="102" cy="64" r="3.5" fill="white"/></g>
                
                <ellipse cx="80" cy="82" rx="6" ry="4.5" fill="#E65100"/>
                
                <path d="M73 88 Q80 96 87 88" stroke="#BF360C" stroke-width="2" fill="none" stroke-linecap="round"/>
                
                <circle cx="46" cy="78" r="11" fill="#FF8A80" opacity="0.45"/>
                <circle cx="114" cy="78" r="11" fill="#FF8A80" opacity="0.45"/>
                
                <line x1="28" y1="80" x2="60" y2="83" stroke="#8D6E63" stroke-width="1.2" opacity="0.7"/>
                <line x1="28" y1="87" x2="60" y2="86" stroke="#8D6E63" stroke-width="1.2" opacity="0.7"/>
                <line x1="100" y1="83" x2="132" y2="80" stroke="#8D6E63" stroke-width="1.2" opacity="0.7"/>
                <line x1="100" y1="86" x2="132" y2="87" stroke="#8D6E63" stroke-width="1.2" opacity="0.7"/>
                
                <ellipse cx="55" cy="154" rx="18" ry="13" fill="#FFA726"/>
                <ellipse cx="105" cy="154" rx="18" ry="13" fill="#FFA726"/>
                <circle cx="47" cy="160" r="5" fill="#FFB300"/>
                <circle cx="55" cy="163" r="5" fill="#FFB300"/>
                <circle cx="63" cy="160" r="5" fill="#FFB300"/>
                <circle cx="97" cy="160" r="5" fill="#FFB300"/>
                <circle cx="105" cy="163" r="5" fill="#FFB300"/>
                <circle cx="113" cy="160" r="5" fill="#FFB300"/>
            </svg>
        </div>

        <p style="font-family:'Nunito',sans-serif;font-weight:800;font-size:1.5rem;color:#3a6b00;margin-bottom:16px;letter-spacing:-0.5px;">
            <?php echo e($siteName); ?>

        </p>
        <div style="display:flex;align-items:center;gap:4px;">
            <span class="loader-dot"></span>
            <span class="loader-dot"></span>
            <span class="loader-dot"></span>
        </div>
        <p style="font-family:'Nunito',sans-serif;font-size:0.8rem;color:#6b9e00;margin-top:10px;">Đang tải tài liệu&#8230;</p>
    </div>
    

    
    <header class="bg-white shadow-sm sticky top-0 z-50" style="background:<?php echo e($navbarBg); ?>;border-bottom:3px solid <?php echo e($navbarBorder); ?>;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 flex-shrink-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($navbarLogoUrl): ?>
                        <img src="<?php echo e($navbarLogoUrl); ?>" alt="<?php echo e($siteName); ?>" style="height:<?php echo e($navbarLogoSize); ?>px;width:auto;object-fit:contain;">
                    <?php else: ?>
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:<?php echo e($navbarBorder); ?>;">
                            <i class="fa-solid <?php echo e($navbarIcon); ?> text-sm" style="color:<?php echo e($navbarTextColor); ?>;"></i>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($navbarShowSiteName): ?>
                        <span class="text-2xl font-bold tracking-tight" style="color:<?php echo e($navbarTextColor); ?>;"><?php echo e($siteName); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>

                
                <nav class="hidden md:flex items-center gap-6">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-600 hover:text-primary-500 font-medium text-sm transition-colors">
                        <i class="fa-solid fa-house mr-1"></i>Trang chủ
                    </a>
                    <a href="<?php echo e(route('search')); ?>" class="text-gray-600 hover:text-primary-500 font-medium text-sm transition-colors">
                        <i class="fa-solid fa-magnifying-glass mr-1"></i>Tìm kiếm
                    </a>

                    
                    <div class="relative group">
                        <button class="text-gray-600 hover:text-primary-500 font-medium text-sm transition-colors flex items-center gap-1">
                            <i class="fa-solid fa-layer-group mr-1"></i>Cấp học
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute top-full left-0 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 hidden group-hover:block z-50">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('category.show', $navCat->slug)); ?>"
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i class="fa-solid <?php echo e($navCat->icon ?? 'fa-folder'); ?> w-4 text-primary-400"></i>
                                <?php echo e($navCat->name); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="relative group">
                        <button class="text-gray-600 hover:text-primary-500 font-medium text-sm transition-colors flex items-center gap-1">
                            <i class="fa-solid fa-file-lines mr-1"></i>Loại tài liệu
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute top-full left-0 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 hidden group-hover:block z-50">
                            <p class="px-4 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Lớp 1–5</p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                                ['Toán',       'fa-calculator',  'text-blue-500'],
                                ['Tiếng Việt', 'fa-pen-nib',     'text-green-600'],
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $icon, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('search', ['mon' => $label])); ?>"
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i class="fa-solid <?php echo e($icon); ?> w-4 <?php echo e($color); ?>"></i>
                                <?php echo e($label); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="border-t border-gray-100 my-1"></div>
                            <p class="px-4 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tiền Tiểu Học</p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                                ['Tô màu',      'fa-palette',   'text-pink-500'],
                                ['Toán tư duy',  'fa-brain',     'text-purple-500'],
                                ['Luyện viết',  'fa-pencil',    'text-orange-500'],
                                ['Luyện đọc',   'fa-book-open', 'text-teal-500'],
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $icon, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('search', ['grade_cat' => 'tien-tieu-hoc', 'mon' => $label])); ?>"
                               class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                <i class="fa-solid <?php echo e($icon); ?> w-4 <?php echo e($color); ?>"></i>
                                <?php echo e($label); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </nav>

                
                <form action="<?php echo e(route('search')); ?>" method="GET" class="hidden md:flex items-center gap-2 flex-1 max-w-xs ml-6">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>"
                               placeholder="Tìm tài liệu..."
                               class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400">
                    </div>
                    <button type="submit" class="text-white px-4 py-2 rounded-lg text-sm font-bold hover:opacity-90 transition-colors" style="background:#7CB800;color:#fff;">
                        Tìm
                    </button>
                </form>

                
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            
            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <form action="<?php echo e(route('search')); ?>" method="GET" class="mb-3">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="q" value="<?php echo e(request('q')); ?>"
                               placeholder="Tìm tài liệu..."
                               class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300">
                    </div>
                </form>
                <div class="space-y-1">
                    <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Trang chủ</a>
                    <a href="<?php echo e(route('search')); ?>" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">Tìm kiếm</a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('category.show', $mCat->slug)); ?>" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                        <i class="fa-solid <?php echo e($mCat->icon ?? 'fa-folder'); ?> mr-2 text-primary-400"></i><?php echo e($mCat->name); ?>

                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="border-t border-gray-100 mt-2 pt-2">
                        <p class="px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Loại tài liệu</p>
                        <div class="px-2 mt-1 space-y-1">
                            <p class="px-2 py-1 text-xs text-gray-400">Lớp 1–5</p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [['Toán','fa-calculator','text-blue-500'],['Tiếng Việt','fa-pen-nib','text-green-600']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label,$icon,$color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('search', ['mon' => $label])); ?>"
                               class="flex items-center gap-2 px-2 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-colors">
                                <i class="fa-solid <?php echo e($icon); ?> w-4 <?php echo e($color); ?>"></i><?php echo e($label); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <p class="px-2 py-1 text-xs text-gray-400">Tiền Tiểu Học</p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [['Tô màu','fa-palette','text-pink-500'],['Luyện viết','fa-pencil','text-orange-500'],['Luyện đọc','fa-book-open','text-teal-500']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label,$icon,$color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('search', ['grade_cat' => 'tien-tieu-hoc', 'mon' => $label])); ?>"
                               class="flex items-center gap-2 px-2 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600 rounded-lg transition-colors">
                                <i class="fa-solid <?php echo e($icon); ?> w-4 <?php echo e($color); ?>"></i><?php echo e($label); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    
    <?php echo $__env->make('components.ad-slot', ['key' => 'ad_slot_header'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <main class="flex-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('components.ad-slot', ['key' => 'ad_slot_footer'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <footer class="text-white mt-12" style="background:<?php echo e($footerBg); ?>;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerLogoUrl): ?>
                            <img src="<?php echo e($footerLogoUrl); ?>" alt="<?php echo e($siteName); ?>" style="height:<?php echo e($footerLogoSize); ?>px;width:auto;object-fit:contain;">
                        <?php else: ?>
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fa-solid <?php echo e($navbarIcon); ?> text-white text-sm"></i>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($navbarShowSiteName): ?>
                        <span class="text-xl font-bold"><?php echo e($siteName); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerTagline): ?>
                    <p class="text-primary-200 text-sm leading-relaxed max-w-sm"><?php echo e($footerTagline); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div>
                    <h3 class="font-semibold mb-3 text-white">Môn học</h3>
                    <ul class="space-y-2 text-sm text-primary-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navCategories->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('category.show', $fCat->slug)); ?>" class="hover:text-white transition-colors">
                                <?php echo e($fCat->name); ?>

                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-3 text-white">Liên kết</h3>
                    <ul class="space-y-2 text-sm text-primary-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($footerLinks) > 0): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $footerLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(trim($fl[1])); ?>" class="hover:text-white transition-colors"><?php echo e(trim($fl[0])); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <li><a href="<?php echo e(route('home')); ?>" class="hover:text-white transition-colors">Trang chủ</a></li>
                            <li><a href="<?php echo e(route('search')); ?>" class="hover:text-white transition-colors">Tìm kiếm</a></li>
                            <li><a href="/admin" class="hover:text-white transition-colors">Quản trị</a></li>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="border-t border-primary-700 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-primary-300">
                    <?php echo e($footerCopyright ?: '© ' . date('Y') . ' ' . $siteName . '. Tất cả quyền được bảo lưu.'); ?>

                </p>
                <p class="text-sm text-primary-400">
                    Tài liệu giáo dục miễn phí cho học sinh Tiểu học
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // ===== LOADER LOGIC =====
        const loader = document.getElementById('page-loader');

        // Hide loader when page fully loaded
        function hideLoader() {
            // Minimum show time 600ms so tiger gets a moment to wave 🐯
            setTimeout(() => loader.classList.add('hide'), 600);
        }
        if (document.readyState === 'complete') {
            hideLoader();
        } else {
            window.addEventListener('load', hideLoader);
            // Fallback: hide after 4s no matter what
            setTimeout(hideLoader, 4000);
        }

        // Page transition: show loader briefly on internal link clicks
        document.addEventListener('click', function (e) {
            const a = e.target.closest('a[href]');
            if (!a) return;
            const href = a.getAttribute('href');
            // Skip: no href, same page hash, external, admin, mailto, download, new tab
            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')
                || a.hasAttribute('download') || a.target === '_blank'
                || href.startsWith('http') && !href.startsWith(window.location.origin)
                || href.includes('/admin') || href.includes('/livewire')) return;
            e.preventDefault();
            loader.classList.remove('hide');
            loader.classList.add('transition-flash');
            setTimeout(() => { window.location.href = href; }, 320);
        });
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Development\Webhoclieu-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>