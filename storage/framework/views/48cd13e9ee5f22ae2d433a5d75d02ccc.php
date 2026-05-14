<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Có lỗi xảy ra'); ?> — <?php echo e(\App\Models\Setting::get('site_name', 'HocLieuTieuHoc')); ?></title>
    <?php
        $faviconUrl = \App\Models\Setting::get('favicon_url', '');
        $siteName   = \App\Models\Setting::get('site_name', 'HocLieuTieuHoc');
    ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($faviconUrl): ?><link rel="icon" href="<?php echo e($faviconUrl); ?>"><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous"/>
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css" crossorigin="anonymous"/></noscript>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous"/>
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" crossorigin="anonymous"/></noscript>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Nunito',sans-serif; background:linear-gradient(160deg,#f0fdf4 0%,#d9f99d 50%,#bbf7d0 100%); min-height:100vh; margin:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
        @keyframes tigerFloat { 0%,100%{transform:translateY(0) rotate(-3deg)} 50%{transform:translateY(-18px) rotate(3deg)} }
        @keyframes tigerBlink { 0%,88%,100%{transform:scaleY(1)} 93%{transform:scaleY(0.08)} }
        @keyframes tailWag   { 0%,100%{transform:rotate(-15deg)} 50%{transform:rotate(15deg)} }
        @keyframes bounce { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
        @keyframes leafFloat { 0%,100%{transform:translateY(0) rotate(0deg);opacity:.7} 50%{transform:translateY(-12px) rotate(15deg);opacity:1} }
        @keyframes numPop { 0%{transform:scale(.5);opacity:0} 70%{transform:scale(1.15)} 100%{transform:scale(1);opacity:1} }
        .tiger-wrap { animation: tigerFloat 2.8s ease-in-out infinite; }
        .tiger-eye  { animation: tigerBlink 3.5s ease-in-out infinite; transform-box:fill-box; transform-origin:center; }
        .tiger-tail { animation: tailWag 1.4s ease-in-out infinite; transform-box:fill-box; transform-origin:bottom left; }
        .leaf       { position:absolute; font-size:1.6rem; animation: leafFloat 3s ease-in-out infinite; pointer-events:none; }
        .err-code   { animation: numPop .7s cubic-bezier(.34,1.56,.64,1) both; }
        .btn-home   { animation: bounce 2s ease-in-out infinite; }
    </style>
</head>
<body>
    
    <span class="leaf" style="top:8%;left:7%;animation-delay:0s">🍃</span>
    <span class="leaf" style="top:14%;right:9%;animation-delay:.9s">🌿</span>
    <span class="leaf" style="bottom:15%;left:6%;animation-delay:1.7s">🍀</span>
    <span class="leaf" style="bottom:12%;right:8%;animation-delay:.4s">🌱</span>

    <div style="text-align:center;padding:2rem;max-width:480px;width:100%;position:relative;z-index:1;">

        
        <div class="tiger-wrap" style="display:inline-block;margin-bottom:1rem;">
            <svg width="<?php echo $__env->yieldContent('tiger-size', '140'); ?>" height="<?php echo $__env->yieldContent('tiger-size', '148'); ?>" viewBox="0 0 160 170" xmlns="http://www.w3.org/2000/svg">
                
                <g class="tiger-tail">
                    <path d="M108 130 Q140 110 138 85 Q136 65 120 68" stroke="#F57F17" stroke-width="10" fill="none" stroke-linecap="round"/>
                    <circle cx="120" cy="65" r="10" fill="#FF8F00"/><circle cx="120" cy="65" r="6" fill="#FFF9C4"/>
                </g>
                
                <ellipse cx="80" cy="125" rx="38" ry="32" fill="#FFA726"/>
                <ellipse cx="80" cy="130" rx="22" ry="18" fill="#FFF8E1"/>
                <path d="M50 110 Q54 125 50 138" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                <path d="M110 110 Q106 125 110 138" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                
                <polygon points="42,42 28,14 56,26" fill="#FFA726"/><polygon points="118,42 132,14 104,26" fill="#FFA726"/>
                <polygon points="44,40 32,18 55,28" fill="#FF8A80"/><polygon points="116,40 128,18 105,28" fill="#FF8A80"/>
                
                <circle cx="80" cy="72" r="46" fill="#FFA726"/>
                <ellipse cx="80" cy="82" rx="28" ry="22" fill="#FFF8E1"/>
                
                <path d="M66 34 Q72 26 80 34" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                <path d="M56 42 Q60 34 66 40" stroke="#E65100" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                <path d="M94 40 Q100 34 104 42" stroke="#E65100" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                
                <circle cx="62" cy="66" r="13" fill="white"/><circle cx="98" cy="66" r="13" fill="white"/>
                <?php echo $__env->yieldContent('tiger-eyes'); ?>
                
                <ellipse cx="80" cy="82" rx="6" ry="4.5" fill="#E65100"/>
                
                <?php echo $__env->yieldContent('tiger-mouth'); ?>
                
                <circle cx="46" cy="78" r="11" fill="#FF8A80" opacity="0.45"/><circle cx="114" cy="78" r="11" fill="#FF8A80" opacity="0.45"/>
                
                <line x1="28" y1="80" x2="58" y2="83" stroke="#8D6E63" stroke-width="1.2" opacity="0.6"/>
                <line x1="28" y1="87" x2="58" y2="86" stroke="#8D6E63" stroke-width="1.2" opacity="0.6"/>
                <line x1="102" y1="83" x2="132" y2="80" stroke="#8D6E63" stroke-width="1.2" opacity="0.6"/>
                <line x1="102" y1="86" x2="132" y2="87" stroke="#8D6E63" stroke-width="1.2" opacity="0.6"/>
                
                <ellipse cx="55" cy="154" rx="18" ry="13" fill="#FFA726"/><ellipse cx="105" cy="154" rx="18" ry="13" fill="#FFA726"/>
                <circle cx="47" cy="160" r="5" fill="#FFB300"/><circle cx="55" cy="163" r="5" fill="#FFB300"/><circle cx="63" cy="160" r="5" fill="#FFB300"/>
                <circle cx="97" cy="160" r="5" fill="#FFB300"/><circle cx="105" cy="163" r="5" fill="#FFB300"/><circle cx="113" cy="160" r="5" fill="#FFB300"/>
                
                <?php echo $__env->yieldContent('tiger-extra'); ?>
            </svg>
        </div>

        
        <div class="err-code" style="font-size:6rem;font-weight:900;line-height:1;color:#3a6b00;margin-bottom:.25rem;letter-spacing:-4px;">
            <?php echo $__env->yieldContent('code', '???'); ?>
        </div>

        <h1 style="font-size:1.5rem;font-weight:800;color:#1f2937;margin:.25rem 0 .5rem;"><?php echo $__env->yieldContent('heading', 'Có lỗi xảy ra'); ?></h1>
        <p style="color:#6b7280;font-size:.95rem;margin-bottom:2rem;line-height:1.6;"><?php echo $__env->yieldContent('message', 'Hổ cũng không biết chuyện gì xảy ra nữa...'); ?></p>

        <?php if (! empty(trim($__env->yieldContent('action-buttons')))): ?>
            <?php echo $__env->yieldContent('action-buttons'); ?>
        <?php else: ?>
        <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
            <a href="<?php echo e(url('/')); ?>" class="btn-home" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:#3a6b00;color:white;border-radius:1rem;font-weight:800;text-decoration:none;font-size:.95rem;box-shadow:0 4px 18px -4px rgba(58,107,0,.4);">
                <i class="fa-solid fa-house"></i> Về trang chủ
            </a>
            <a href="javascript:history.back()" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:white;color:#374151;border:2px solid #d1fae5;border-radius:1rem;font-weight:700;text-decoration:none;font-size:.95rem;">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <p style="margin-top:2rem;font-size:.75rem;color:#9ca3af;">
            <a href="<?php echo e(url('/')); ?>" style="color:#6b9e00;text-decoration:none;font-weight:700;"><?php echo e($siteName); ?></a>
            &nbsp;·&nbsp; Thư viện tài liệu Tiểu học miễn phí
        </p>
    </div>
</body>
</html>
<?php /**PATH D:\Development\Webhoclieu-laravel\resources\views/errors/layout.blade.php ENDPATH**/ ?>