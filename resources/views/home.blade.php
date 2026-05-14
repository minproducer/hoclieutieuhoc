@extends('layouts.app')

@section('title', 'HocLieuTieuHoc - Thư viện tài liệu giáo dục Tiểu học miễn phí')
@section('description', 'HocLieuTieuHoc - Kho tài liệu giáo dục miễn phí cho học sinh Tiểu học. PDF, DOCX, PPTX — bài ôn tập, đề thi, rèn kĩ năng từ lớp Tiền tiểu học đến lớp 5.')

@section('head')
<style>
/* ── Hero entrance animations ── */
@keyframes slideLeft  { from{opacity:0;transform:translateX(-36px)} to{opacity:1;transform:translateX(0)} }
@keyframes slideRight { from{opacity:0;transform:translateX(36px)}  to{opacity:1;transform:translateX(0)} }
@keyframes fadeUp     { from{opacity:0;transform:translateY(16px)}  to{opacity:1;transform:translateY(0)} }
.hero-left  { animation:slideLeft  .7s cubic-bezier(.22,1,.36,1) both; }
.hero-right { animation:slideRight .7s cubic-bezier(.22,1,.36,1) .12s both; }

/* ── Hero doc card floats ── */
@keyframes floatA { 0%,100%{transform:rotate(-5deg) translateY(0)}  50%{transform:rotate(-3deg) translateY(-13px)} }
@keyframes floatB { 0%,100%{transform:rotate(4deg)  translateY(0)}  50%{transform:rotate(2.5deg) translateY(-10px)} }
@keyframes floatC { 0%,100%{transform:rotate(-2deg) translateY(0)}  50%{transform:rotate(0.5deg) translateY(-8px)} }
.doc-fa{ animation:floatA 6s ease-in-out         infinite }
.doc-fb{ animation:floatB 7s ease-in-out 1.2s    infinite }
.doc-fc{ animation:floatC 8s ease-in-out 2.4s    infinite }

/* ── Mascot bounce ── */
@keyframes mascotBounce { 0%,100%{transform:translateY(0) rotate(-2deg)} 50%{transform:translateY(-14px) rotate(2deg)} }
.hero-mascot{ animation:mascotBounce 3.2s ease-in-out infinite; transform-origin:bottom center; }

/* ── Hero doc cards ── */
.hdoc{
    width:230px;background:white;border-radius:16px;padding:15px 16px;
    box-shadow:0 20px 60px -10px rgba(0,0,0,.18),0 4px 12px rgba(0,0,0,.07),inset 0 1px 0 rgba(255,255,255,1);
}

/* ── Search button shimmer — lime/yellow ── */
@keyframes btnShimmer {
    0%   { background-position:-200% center }
    100% { background-position: 200% center }
}
.hero-btn{
    background:linear-gradient(90deg,#DFFF00 0%,#AACC00 40%,#DFFF00 80%,#AACC00 100%);
    background-size:200% auto;
    animation:btnShimmer 2.8s linear infinite;
    box-shadow:0 4px 16px rgba(130,180,0,.35);
    transition:transform .15s,box-shadow .15s;
    color:#2a3d00 !important;
}
.hero-btn:hover{ transform:scale(1.04);box-shadow:0 6px 24px rgba(130,180,0,.55); }

/* ── Stat chip pulse ── */
@keyframes statPulse {
    0%,100% { box-shadow:0 0 0   0 rgba(223,255,0,.0) }
    55%     { box-shadow:0 0 14px 4px rgba(223,255,0,.28) }
}
.stat-chip-gold  { animation:statPulse 3.5s ease-in-out infinite }

/* ── Quick filter pills ── */
.qpill{
    display:inline-flex;align-items:center;gap:6px;
    padding:6px 13px;border-radius:99px;font-size:12.5px;font-weight:700;
    color:#2e4800;
    background:rgba(90,140,0,.12);border:1px solid rgba(90,140,0,.25);
    text-decoration:none;transition:all .18s;
}
.qpill:hover{ background:rgba(90,140,0,.22);color:#1a3200;transform:translateY(-2px) }

/* ── Subject pills ── */
.subj-pill{
    display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:99px;
    background:white;border:1.5px solid #e5e7eb;color:#374151;font-weight:700;font-size:14px;
    text-decoration:none;transition:all .2s;box-shadow:0 2px 6px rgba(0,0,0,.05);
}
.subj-pill:hover{ border-color:#5a9e00;color:#3d6e00;background:#f4ffe0;transform:translateY(-2px);box-shadow:0 8px 16px -6px rgba(90,158,0,.2) }

/* ── Grade cards ── */
.grade-card{ transition:all .2s }
.grade-card:hover .grade-icon{ transform:scale(1.12) }
.grade-icon{ transition:transform .2s }

/* ── Search focus ring ── */
.hero-search-wrap:focus-within{ box-shadow:0 8px 32px -4px rgba(80,130,0,.25),0 0 0 3px rgba(90,158,0,.35) !important; }

/* ── Typewriter cursor blink ── */
@keyframes caretBlink { 0%,100%{opacity:1} 50%{opacity:0} }
#tw-cursor{ animation:caretBlink .7s step-end infinite; }
</style>
@endsection

@section('content')

{{-- ============ HERO ============ --}}
@php
    $heroMascot        = \App\Models\Setting::get('hero_mascot_url', 'https://e7.pngegg.com/pngimages/68/965/png-clipart-library-thinking-cartoon-children-cartoon-character-template.png');
    $heroMascotSize    = (int) \App\Models\Setting::get('hero_mascot_size', 180);
    $heroStatDocs      = \App\Models\Setting::get('hero_stat_docs', '12,500+ tài liệu');
    $heroStatDownloads = \App\Models\Setting::get('hero_stat_downloads', '58,000+ lượt tải');
    $heroStatFree      = \App\Models\Setting::get('hero_stat_free', 'Hoàn toàn miễn phí');
    $heroCard1Subject  = \App\Models\Setting::get('hero_card1_subject', 'PDF · Toán');
    $heroCard1Title    = \App\Models\Setting::get('hero_card1_title', "Đề kiểm tra Toán\nHọc kì 1 · Lớp 4");
    $heroCard1Views    = \App\Models\Setting::get('hero_card1_views', '2,400 lượt tải');
    $heroCard2Subject  = \App\Models\Setting::get('hero_card2_subject', 'PPTX · Tiếng Việt');
    $heroCard2Title    = \App\Models\Setting::get('hero_card2_title', "Bài giảng Tiếng Việt\nTuần 12 · Lớp 3");
    $heroCard2Views    = \App\Models\Setting::get('hero_card2_views', '1,800 lượt tải');
    $heroCard3Subject  = \App\Models\Setting::get('hero_card3_subject', 'DOCX · Tập viết');
    $heroCard3Title    = \App\Models\Setting::get('hero_card3_title', "Luyện viết chữ đẹp\nQuyển 1 · Lớp 1");
    $heroCard3Views    = \App\Models\Setting::get('hero_card3_views', '3,200 lượt tải');
@endphp
<section class="relative overflow-hidden"
         style="background:#C8DC00;padding:4.5rem 1.5rem 8rem;">

    {{-- Subtle white circles --}}
    <div class="absolute pointer-events-none" style="width:550px;height:550px;top:-160px;right:-100px;background:rgba(255,255,255,.18);border-radius:50%;"></div>
    <div class="absolute pointer-events-none" style="width:360px;height:360px;bottom:-80px;left:-60px;background:rgba(255,255,255,.12);border-radius:50%;"></div>

    {{-- Wave bottom --}}
    <div class="absolute bottom-0 left-0 right-0 pointer-events-none" style="line-height:0;">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" style="width:100%;display:block;height:60px;">
            <path d="M0,60 C360,50 720,58 1080,48 C1260,44 1360,54 1440,52 L1440,60Z" fill="#F8FFE0"/>
        </svg>
    </div>

    {{-- Split layout: LEFT text | RIGHT cards | MASCOT centered bottom --}}
    <div class="relative max-w-6xl mx-auto" style="display:grid;grid-template-columns:1fr 400px;gap:3rem;align-items:center;" id="hero-grid">

        {{-- ── LEFT: Text + CTA ── --}}
        <div style="text-align:left;">

            {{-- H1 typewriter --}}
            <h1 style="font-size:clamp(2rem,4.5vw,3.4rem);font-weight:900;line-height:1.13;color:#1a3200;margin-bottom:2rem;letter-spacing:-.025em;min-height:5em;">
                <span id="tw-text"></span><span id="tw-cursor" style="color:#2e4800;animation:caretBlink 1s step-end infinite;">|</span>
            </h1>

            {{-- CTA Button --}}
            <a href="{{ route('search') }}"
               style="display:inline-flex;align-items:center;gap:10px;background:white;color:#2e4800;font-weight:800;font-size:1.05rem;padding:17px 44px;border-radius:99px;text-decoration:none;box-shadow:0 6px 20px rgba(0,0,0,.14);transition:all .2s;"
               onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 14px 36px rgba(0,0,0,.2)'"
               onmouseout="this.style.transform='';this.style.boxShadow='0 6px 20px rgba(0,0,0,.14)'">
                <i class="fa-solid fa-magnifying-glass"></i>
                Khám phá tài liệu ngay
            </a>

            {{-- Stats strip --}}
            <div style="display:flex;align-items:center;flex-wrap:wrap;gap:20px;margin-top:2rem;">
                <div style="display:flex;align-items:center;gap:8px;font-size:14px;font-weight:700;color:#1a3200;">
                    <i class="fa-solid fa-file-lines"></i>
                    <span>{{ $heroStatDocs }}</span>
                </div>
                <div style="width:1px;height:16px;background:rgba(26,50,0,.3);"></div>
                <div style="display:flex;align-items:center;gap:8px;font-size:14px;font-weight:700;color:#1a3200;">
                    <i class="fa-solid fa-download"></i>
                    <span>{{ $heroStatDownloads }}</span>
                </div>
                <div style="width:1px;height:16px;background:rgba(26,50,0,.3);"></div>
                <div style="display:flex;align-items:center;gap:8px;font-size:14px;font-weight:700;color:#1a3200;">
                    <i class="fa-solid fa-star"></i>
                    <span>{{ $heroStatFree }}</span>
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Floating doc cards ── --}}
        <div style="position:relative;height:420px;">

            {{-- Card 1 — PDF --}}
            <div class="doc-fa" style="position:absolute;top:0;right:10px;">
                <div class="hdoc">
                    <div style="display:flex;align-items:center;gap:11px;margin-bottom:12px;">
                        <div style="width:40px;height:48px;background:linear-gradient(150deg,#ef4444,#c42020);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 8px rgba(239,68,68,.35);">
                            <b style="font:900 9px/1 Arial,sans-serif;color:white;letter-spacing:.1em;">PDF</b>
                        </div>
                        <div>
                            <div style="font-size:10px;font-weight:800;color:#ef4444;text-transform:uppercase;letter-spacing:.08em;margin-bottom:3px;">{{ $heroCard1Subject }}</div>
                            <div style="font-size:13px;font-weight:700;color:#111827;line-height:1.35;">{!! nl2br(e($heroCard1Title)) !!}</div>
                        </div>
                    </div>
                    <div style="height:3px;background:#f3f4f6;border-radius:99px;overflow:hidden;margin-bottom:9px;">
                        <div style="width:72%;height:100%;background:linear-gradient(90deg,#ef4444,#f87171);border-radius:99px;"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#9ca3af;">
                        <span>{{ $heroCard1Views }}</span>
                        <span style="background:#dcfce7;color:#16a34a;font-weight:700;padding:2px 8px;border-radius:99px;">Miễn phí</span>
                    </div>
                </div>
            </div>

            {{-- Card 2 — PPTX --}}
            <div class="doc-fb" style="position:absolute;top:145px;right:40px;">
                <div class="hdoc">
                    <div style="display:flex;align-items:center;gap:11px;margin-bottom:12px;">
                        <div style="width:40px;height:48px;background:linear-gradient(150deg,#f97316,#c45c0a);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 8px rgba(249,115,22,.35);">
                            <b style="font:900 9px/1 Arial,sans-serif;color:white;letter-spacing:.1em;">PPT</b>
                        </div>
                        <div>
                            <div style="font-size:10px;font-weight:800;color:#f97316;text-transform:uppercase;letter-spacing:.08em;margin-bottom:3px;">{{ $heroCard2Subject }}</div>
                            <div style="font-size:13px;font-weight:700;color:#111827;line-height:1.35;">{!! nl2br(e($heroCard2Title)) !!}</div>
                        </div>
                    </div>
                    <div style="height:3px;background:#f3f4f6;border-radius:99px;overflow:hidden;margin-bottom:9px;">
                        <div style="width:55%;height:100%;background:linear-gradient(90deg,#f97316,#fb923c);border-radius:99px;"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#9ca3af;">
                        <span>{{ $heroCard2Views }}</span>
                        <span style="background:#dcfce7;color:#16a34a;font-weight:700;padding:2px 8px;border-radius:99px;">Miễn phí</span>
                    </div>
                </div>
            </div>

            {{-- Card 3 — DOCX --}}
            <div class="doc-fc" style="position:absolute;top:290px;right:15px;">
                <div class="hdoc">
                    <div style="display:flex;align-items:center;gap:11px;margin-bottom:12px;">
                        <div style="width:40px;height:48px;background:linear-gradient(150deg,#3b82f6,#1d4ed8);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 8px rgba(59,130,246,.35);">
                            <b style="font:900 9px/1 Arial,sans-serif;color:white;letter-spacing:.1em;">DOC</b>
                        </div>
                        <div>
                            <div style="font-size:10px;font-weight:800;color:#3b82f6;text-transform:uppercase;letter-spacing:.08em;margin-bottom:3px;">{{ $heroCard3Subject }}</div>
                            <div style="font-size:13px;font-weight:700;color:#111827;line-height:1.35;">{!! nl2br(e($heroCard3Title)) !!}</div>
                        </div>
                    </div>
                    <div style="height:3px;background:#f3f4f6;border-radius:99px;overflow:hidden;margin-bottom:9px;">
                        <div style="width:84%;height:100%;background:linear-gradient(90deg,#3b82f6,#60a5fa);border-radius:99px;"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:11px;color:#9ca3af;">
                        <span>{{ $heroCard3Views }}</span>
                        <span style="background:#dcfce7;color:#16a34a;font-weight:700;padding:2px 8px;border-radius:99px;">Miễn phí</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Mascot — centered bottom, overlapping the wave --}}
    @if($heroMascot)
    <div class="hero-mascot" style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);z-index:10;pointer-events:none;">
        <img src="{{ $heroMascot }}" alt=""
             style="width:{{ $heroMascotSize }}px;height:auto;mix-blend-mode:multiply;">
    </div>
    @endif

</section>

<script>
(function(){
    // Collapse to 1-col on mobile
    var grid = document.getElementById('hero-grid');
    if(grid && window.innerWidth < 900){
        grid.style.gridTemplateColumns = '1fr';
    }

    var tw     = document.getElementById('tw-text');
    var cursor = document.getElementById('tw-cursor');
    if(!tw) return;

    var segments = [
        {chars: 'Nói lời tạm biệt với việc\ntìm tài liệu khắp nơi —\n', lime: false},
        {chars: 'kho học liệu miễn phí', lime: true},
        {chars: '\ndành riêng cho Tiểu học!', lime: false}
    ];
    var allChars = [];
    segments.forEach(function(seg){
        seg.chars.split('').forEach(function(c){ allChars.push({c:c, lime:seg.lime}); });
    });

    var i = 0;
    function type(){
        if(i >= allChars.length){
            setTimeout(function(){ if(cursor) cursor.style.display='none'; }, 1500);
            return;
        }
        var html = ''; var inLime = false;
        for(var j = 0; j <= i; j++){
            var ch = allChars[j];
            if(ch.lime && !inLime){ html += '<span style="background:white;color:#2e6e00;padding:0 8px;border-radius:6px;display:inline-block;">'; inLime=true; }
            if(!ch.lime && inLime){ html += '</span>'; inLime=false; }
            if(ch.c === '\n') html += '<br>';
            else html += ch.c.replace(/&/g,'&amp;').replace(/</g,'&lt;');
        }
        if(inLime) html += '</span>';
        tw.innerHTML = html;
        i++;
        setTimeout(type, 38);
    }
    setTimeout(type, 400);
})();
</script>
@include('components.ad-slot', ['key' => 'ad_slot_in_content'])

{{-- ============ STATS ============ --}}
<section style="background:white;border-bottom:1px solid #f3ede4;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @php
            $dTotal = max($stats['total_documents'], 12500);
            $dViews = max($stats['total_views'],     130000);
            $dDL    = max($stats['total_downloads'],  58000);
            $dCats  = max($stats['total_categories'],     6);
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-0 divide-x divide-gray-100">
            <div style="text-align:center;padding:20px 16px;">
                <div style="width:48px;height:48px;border-radius:14px;background:#faf5ee;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="#8B6035" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M14 2v6h6M8 13h8M8 17h6" stroke="#8B6035" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div style="font-size:1.65rem;font-weight:900;color:#1f2937;line-height:1;">{{ number_format($dTotal) }}+</div>
                <div style="font-size:11px;color:#9ca3af;font-weight:600;margin-top:4px;text-transform:uppercase;letter-spacing:.06em;">Tài liệu</div>
            </div>
            <div style="text-align:center;padding:20px 16px;">
                <div style="width:48px;height:48px;border-radius:14px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="#3b82f6" stroke-width="2" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="3" stroke="#3b82f6" stroke-width="2"/>
                    </svg>
                </div>
                <div style="font-size:1.65rem;font-weight:900;color:#1f2937;line-height:1;">{{ number_format($dViews) }}+</div>
                <div style="font-size:11px;color:#9ca3af;font-weight:600;margin-top:4px;text-transform:uppercase;letter-spacing:.06em;">Lượt xem</div>
            </div>
            <div style="text-align:center;padding:20px 16px;">
                <div style="width:48px;height:48px;border-radius:14px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3v12m0 0l-4-4m4 4l4-4" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5 20h14" stroke="#16a34a" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div style="font-size:1.65rem;font-weight:900;color:#1f2937;line-height:1;">{{ number_format($dDL) }}+</div>
                <div style="font-size:11px;color:#9ca3af;font-weight:600;margin-top:4px;text-transform:uppercase;letter-spacing:.06em;">Lượt tải</div>
            </div>
            <div style="text-align:center;padding:20px 16px;">
                <div style="width:48px;height:48px;border-radius:14px;background:#fffbeb;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="18" height="18" rx="2" stroke="#d97706" stroke-width="2"/>
                        <path d="M3 9h18M9 21V9" stroke="#d97706" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div style="font-size:1.65rem;font-weight:900;color:#1f2937;line-height:1;">{{ $dCats }}</div>
                <div style="font-size:11px;color:#9ca3af;font-weight:600;margin-top:4px;text-transform:uppercase;letter-spacing:.06em;">Khối lớp</div>
            </div>
        </div>
    </div>
</section>

{{-- ============ GRADE LEVELS ============ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-7">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fa-solid fa-graduation-cap text-primary-500 mr-2"></i>Chọn khối lớp
        </h2>
        <p class="text-sm text-gray-400 mt-1">Tìm tài liệu phù hợp theo cấp học của bé</p>
    </div>

    @php
        $gradeColors = ['#fef3c7','#fce7f3','#dbeafe','#dcfce7','#ede9fe','#ffedd5','#e0f2fe','#fdf2f8'];
        $gradeIconColors = ['#d97706','#be185d','#1d4ed8','#15803d','#6d28d9','#c2410c','#0369a1','#9d174d'];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
        @foreach($categories as $i => $category)
        @php $ci = $i % 8; @endphp
        <a href="{{ route('category.show', $category->slug) }}"
           class="grade-card group flex flex-col items-center gap-2.5 bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1.5 transition-all duration-200 text-center text-decoration-none"
           style="text-decoration:none;">
            <div class="grade-icon w-14 h-14 rounded-2xl flex items-center justify-center"
                 style="background:{{ $gradeColors[$ci] }};">
                <i class="fa-solid {{ $category->icon ?? 'fa-book-open' }} text-xl" style="color:{{ $gradeIconColors[$ci] }};"></i>
            </div>
            <span class="font-bold text-sm text-gray-700 group-hover:text-primary-600 transition-colors leading-tight">{{ $category->name }}</span>
            @if(($category->doc_count ?? 0) > 0)
            <span class="text-[11px] text-gray-400">{{ $category->doc_count }} tài liệu</span>
            @endif
        </a>
        @endforeach
    </div>
</section>

{{-- ============ SUBJECTS ============ --}}
<section style="background:white;padding:2.5rem 0 3rem;border-top:1px solid #f3ede4;border-bottom:1px solid #f3ede4;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-layer-group text-primary-500 mr-2"></i>Phổ biến
        </h2>
        @php
        $subjects = [
            // [$name, $icon_class, $icon_color, $q]
            ['Toán học',       'fa-calculator',    '#3b82f6', 'Toán'],
            ['Tiếng Việt',     'fa-book',          '#d97706', 'Tiếng Việt'],
            ['Tiếng Anh',      'fa-globe',         '#16a34a', 'Tiếng Anh'],
            ['Tự nhiên & XH',  'fa-leaf',          '#15803d', 'Tự nhiên xã hội'],
            ['Đạo đức',        'fa-heart',         '#e11d48', 'Đạo đức'],
            ['Mỹ thuật',       'fa-palette',       '#7c3aed', 'Mỹ thuật'],
            ['Âm nhạc',        'fa-music',         '#db2777', 'Âm nhạc'],
            ['Tô màu',         'fa-pen-nib',       '#ea580c', 'tô màu'],
            ['Luyện viết',     'fa-pen',           '#4f46e5', 'luyện viết'],
            ['Đề kiểm tra',    'fa-clipboard-list','#8B6035', 'đề kiểm tra'],
        ];
        @endphp
        <div style="display:flex;flex-wrap:wrap;gap:10px;">
            @foreach($subjects as [$name, $icon, $iconColor, $q])
            <a href="{{ route('search', ['q' => $q]) }}" class="subj-pill">
                <i class="fa-solid {{ $icon }}" style="color:{{ $iconColor }};"></i>
                <span>{{ $name }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ FEATURED DOCUMENTS ============ --}}
@if($featuredDocs->isNotEmpty())
<section style="background:#faf5ee;padding:3rem 0;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-7">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fa-solid fa-star text-yellow-400 mr-2"></i>Tài liệu nổi bật
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">Được tải nhiều nhất tuần này</p>
            </div>
            <a href="{{ route('search') }}" class="text-sm font-semibold text-primary-500 hover:text-primary-600 flex items-center gap-1.5">
                Xem tất cả <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($featuredDocs as $doc)
            <x-document-card :document="$doc" />
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ RECENT DOCUMENTS ============ --}}
@if($recentDocs->isNotEmpty())
<section style="padding:3rem 0;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-7">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fa-solid fa-clock-rotate-left text-primary-500 mr-2"></i>Mới nhất
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">Tài liệu vừa được thêm vào thư viện</p>
            </div>
            <a href="{{ route('search', ['sort' => 'newest']) }}" class="text-sm font-semibold text-primary-500 hover:text-primary-600 flex items-center gap-1.5">
                Xem tất cả <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($recentDocs as $doc)
            <x-document-card :document="$doc" />
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ CTA BANNER ============ --}}
<section style="background:linear-gradient(135deg,#2e4800 0%,#558000 50%,#88bb00 100%);padding:4.5rem 0;">
    <div style="max-width:680px;margin:0 auto;padding:0 1.5rem;text-align:center;">
        <div style="margin-bottom:1rem;">
            <div style="width:64px;height:64px;border-radius:20px;background:rgba(223,255,0,.2);border:1px solid rgba(223,255,0,.35);display:flex;align-items:center;justify-content:center;margin:0 auto;">
                <i class="fa-solid fa-book-open" style="font-size:1.75rem;color:#DFFF00;"></i>
            </div>
        </div>
        <h2 style="font-size:1.9rem;font-weight:900;color:white;margin-bottom:.75rem;line-height:1.25;">
            Tất cả tài liệu đều miễn phí
        </h2>
        <p style="color:rgba(255,255,255,.8);font-size:15px;line-height:1.75;margin-bottom:1.75rem;max-width:460px;margin-left:auto;margin-right:auto;">
            Không cần đăng nhập, không mất phí, không giới hạn.<br>
            Hàng nghìn tài liệu chất lượng dành riêng cho học sinh Tiểu học Việt Nam.
        </p>
        <a href="{{ route('search') }}"
           style="display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#DFFF00,#AACC00);color:#2a3d00;font-weight:800;font-size:15px;padding:14px 32px;border-radius:16px;text-decoration:none;box-shadow:0 8px 24px rgba(180,220,0,.5);"
           onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 14px 32px rgba(180,220,0,.7)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 8px 24px rgba(180,220,0,.5)'">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                <circle cx="9" cy="9" r="7" stroke="currentColor" stroke-width="2.5"/>
                <path d="M16 16l-3.5-3.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
            Khám phá tài liệu ngay
        </a>
    </div>
</section>

@endsection
