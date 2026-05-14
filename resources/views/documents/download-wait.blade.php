@extends('layouts.app')

@section('title', 'Tải xuống — ' . $document->title . ' - ' . \App\Models\Setting::get('site_name', 'HocLieuTieuHoc'))
@section('description', 'Tải miễn phí: ' . $document->title)

@section('content')
@php
    use Illuminate\Support\Str;
    $fileTypeIcons = [
        'pdf'   => 'fa-file-pdf',
        'docx'  => 'fa-file-word',
        'pptx'  => 'fa-file-powerpoint',
        'xlsx'  => 'fa-file-excel',
        'zip'   => 'fa-file-zipper',
        'image' => 'fa-file-image',
    ];
    $fileTypeColors = [
        'pdf'   => 'badge-pdf',
        'docx'  => 'badge-docx',
        'pptx'  => 'badge-pptx',
        'xlsx'  => 'badge-xlsx',
        'zip'   => 'badge-zip',
        'image' => 'badge-image',
    ];
@endphp

{{-- AD: Top banner --}}
@include('components.ad-slot', ['key' => 'ad_slot_header'])

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

    {{-- ===== DECO TIGERS (fixed corners, only on md+) ===== --}}
    {{-- Tiger left (peeking from left edge) --}}
    <div class="deco-tiger tiger-peek hidden lg:block" style="position:fixed;left:-28px;bottom:160px;z-index:10;">
        <svg width="90" height="90" viewBox="0 0 160 170" xmlns="http://www.w3.org/2000/svg" opacity="0.82">
            <ellipse cx="80" cy="125" rx="38" ry="32" fill="#FFA726"/>
            <ellipse cx="80" cy="130" rx="22" ry="18" fill="#FFF8E1"/>
            <polygon points="42,42 28,14 56,26" fill="#FFA726"/><polygon points="118,42 132,14 104,26" fill="#FFA726"/>
            <polygon points="44,40 32,18 55,28" fill="#FF8A80"/><polygon points="116,40 128,18 105,28" fill="#FF8A80"/>
            <circle cx="80" cy="72" r="46" fill="#FFA726"/>
            <ellipse cx="80" cy="82" rx="28" ry="22" fill="#FFF8E1"/>
            <path d="M66 34 Q72 26 80 34" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
            <circle cx="62" cy="66" r="13" fill="white"/><circle cx="98" cy="66" r="13" fill="white"/>
            <g class="tiger-eye-anim"><circle cx="63" cy="67" r="9" fill="#1a1a1a"/><circle cx="66" cy="64" r="3" fill="white"/></g>
            <g class="tiger-eye-anim" style="animation-delay:.3s"><circle cx="99" cy="67" r="9" fill="#1a1a1a"/><circle cx="102" cy="64" r="3" fill="white"/></g>
            <ellipse cx="80" cy="82" rx="6" ry="4" fill="#E65100"/>
            <path d="M73 88 Q80 95 87 88" stroke="#BF360C" stroke-width="2" fill="none" stroke-linecap="round"/>
            <circle cx="46" cy="78" r="11" fill="#FF8A80" opacity="0.4"/><circle cx="114" cy="78" r="11" fill="#FF8A80" opacity="0.4"/>
            <ellipse cx="55" cy="154" rx="18" ry="13" fill="#FFA726"/><ellipse cx="105" cy="154" rx="18" ry="13" fill="#FFA726"/>
        </svg>
    </div>
    {{-- Tiger right (floating) --}}
    <div class="deco-tiger tiger-float hidden lg:block" style="position:fixed;right:10px;bottom:120px;z-index:10;">
        <svg width="80" height="80" viewBox="0 0 160 170" xmlns="http://www.w3.org/2000/svg" opacity="0.75" style="transform:scaleX(-1)">
            <ellipse cx="80" cy="125" rx="38" ry="32" fill="#FFA726"/>
            <ellipse cx="80" cy="130" rx="22" ry="18" fill="#FFF8E1"/>
            <polygon points="42,42 28,14 56,26" fill="#FFA726"/><polygon points="118,42 132,14 104,26" fill="#FFA726"/>
            <polygon points="44,40 32,18 55,28" fill="#FF8A80"/><polygon points="116,40 128,18 105,28" fill="#FF8A80"/>
            <circle cx="80" cy="72" r="46" fill="#FFA726"/>
            <ellipse cx="80" cy="82" rx="28" ry="22" fill="#FFF8E1"/>
            <path d="M66 34 Q72 26 80 34" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
            <circle cx="62" cy="66" r="13" fill="white"/><circle cx="98" cy="66" r="13" fill="white"/>
            <circle cx="63" cy="67" r="9" fill="#1a1a1a"/><circle cx="66" cy="64" r="3" fill="white"/>
            <circle cx="99" cy="67" r="9" fill="#1a1a1a"/><circle cx="102" cy="64" r="3" fill="white"/>
            <ellipse cx="80" cy="82" rx="6" ry="4" fill="#E65100"/>
            <path d="M73 88 Q80 95 87 88" stroke="#BF360C" stroke-width="2" fill="none" stroke-linecap="round"/>
            <circle cx="46" cy="78" r="11" fill="#FF8A80" opacity="0.4"/><circle cx="114" cy="78" r="11" fill="#FF8A80" opacity="0.4"/>
        </svg>
    </div>

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">Trang chủ</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        @if($document->category)
        <a href="{{ route('category.show', $document->category->slug) }}" class="hover:text-primary-600 transition-colors">{{ $document->category->name }}</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        @endif
        <a href="{{ route('document.show', $document->slug) }}" class="hover:text-primary-600 transition-colors truncate max-w-[200px]">{{ $document->title }}</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-gray-600">Tải xuống</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===== MAIN: countdown + download ===== --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- File info strip --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid {{ $fileTypeIcons[$document->file_type] ?? 'fa-file' }} text-xl text-primary-500"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-900 truncate leading-tight">{{ $document->title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        <span class="{{ $fileTypeColors[$document->file_type] ?? '' }} text-[10px] font-bold px-1.5 py-0.5 rounded mr-1">{{ strtoupper($document->file_type) }}</span>
                        {{ $document->category?->name }}@if($document->grade_level) · Lớp {{ $document->grade_level }}@endif
                    </p>
                </div>
            </div>

            {{-- ===== COUNTDOWN CARD ===== --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">

                {{-- Tiny deco tigers on card corners --}}
                <div style="position:absolute;top:8px;left:10px;opacity:0.18;pointer-events:none;">
                    <svg width="38" height="38" viewBox="0 0 160 170" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="80" cy="72" r="46" fill="#FFA726"/><ellipse cx="80" cy="82" rx="28" ry="22" fill="#FFF8E1"/>
                        <circle cx="62" cy="66" r="13" fill="white"/><circle cx="98" cy="66" r="13" fill="white"/>
                        <circle cx="63" cy="67" r="9" fill="#1a1a1a"/><circle cx="99" cy="67" r="9" fill="#1a1a1a"/>
                        <ellipse cx="80" cy="82" rx="6" ry="4" fill="#E65100"/>
                        <path d="M73 88 Q80 95 87 88" stroke="#BF360C" stroke-width="2" fill="none"/>
                        <circle cx="46" cy="78" r="11" fill="#FF8A80" opacity="0.5"/><circle cx="114" cy="78" r="11" fill="#FF8A80" opacity="0.5"/>
                    </svg>
                </div>
                <div style="position:absolute;top:8px;right:10px;opacity:0.18;pointer-events:none;transform:scaleX(-1);">
                    <svg width="38" height="38" viewBox="0 0 160 170" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="80" cy="72" r="46" fill="#FFA726"/><ellipse cx="80" cy="82" rx="28" ry="22" fill="#FFF8E1"/>
                        <circle cx="62" cy="66" r="13" fill="white"/><circle cx="98" cy="66" r="13" fill="white"/>
                        <circle cx="63" cy="67" r="9" fill="#1a1a1a"/><circle cx="99" cy="67" r="9" fill="#1a1a1a"/>
                        <ellipse cx="80" cy="82" rx="6" ry="4" fill="#E65100"/>
                        <path d="M73 88 Q80 95 87 88" stroke="#BF360C" stroke-width="2" fill="none"/>
                        <circle cx="46" cy="78" r="11" fill="#FF8A80" opacity="0.5"/><circle cx="114" cy="78" r="11" fill="#FF8A80" opacity="0.5"/>
                    </svg>
                </div>

                {{-- Waiting state --}}
                <div id="waiting-state" class="px-6 py-14 flex flex-col items-center">

                    {{-- Ring (CSS grid overlay — reliable centering) --}}
                    <div class="mb-8" style="display:grid;place-items:center;width:160px;height:160px;">
                        <svg width="160" height="160" viewBox="0 0 160 160"
                             style="grid-area:1/1;transform:rotate(-90deg);">
                            <circle cx="80" cy="80" r="68" fill="none" stroke="#f3ede4" stroke-width="10" stroke-linecap="round"/>
                            <circle id="countdown-ring" cx="80" cy="80" r="68"
                                fill="none" stroke="#8B6035" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="427.3" stroke-dashoffset="427.3"/>
                        </svg>
                        {{-- Number overlay on same grid cell --}}
                        <div style="grid-area:1/1;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
                            <span id="countdown-number"
                                  style="font-size:3.25rem;font-weight:900;color:#78350f;line-height:1;font-variant-numeric:tabular-nums;">10</span>
                            <span style="font-size:10px;font-weight:700;color:#9ca3af;letter-spacing:.15em;text-transform:uppercase;margin-top:5px;">GIÂY</span>
                        </div>
                    </div>

                    {{-- Progress bar --}}
                    <div class="w-full max-w-xs bg-gray-100 rounded-full h-1.5 mb-6 overflow-hidden">
                        <div id="progress-bar" class="h-full rounded-full bg-primary-400 transition-all duration-1000 ease-linear" style="width:0%"></div>
                    </div>

                    <p class="text-gray-400 text-sm">
                        Đang chuẩn bị file
                        <span id="dots" class="font-bold text-primary-400"></span>
                    </p>
                </div>

                {{-- Ready state (hidden) --}}
                <div id="ready-state" class="hidden px-6 py-10 flex flex-col items-center text-center">

                    {{-- Confetti container --}}
                    <div id="confetti-box" style="position:relative;width:100%;height:0;overflow:visible;"></div>

                    {{-- Celebrating tiger --}}
                    <div style="margin-bottom:8px;" class="tiger-float">
                        <svg width="100" height="108" viewBox="0 0 160 170" xmlns="http://www.w3.org/2000/svg">
                            <path d="M108 130 Q140 110 138 85 Q136 65 120 68" stroke="#F57F17" stroke-width="10" fill="none" stroke-linecap="round"/>
                            <circle cx="120" cy="65" r="10" fill="#FF8F00"/><circle cx="120" cy="65" r="6" fill="#FFF9C4"/>
                            <ellipse cx="80" cy="125" rx="38" ry="32" fill="#FFA726"/>
                            <ellipse cx="80" cy="130" rx="22" ry="18" fill="#FFF8E1"/>
                            <path d="M50 110 Q54 125 50 138" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                            <path d="M110 110 Q106 125 110 138" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                            <polygon points="42,42 28,14 56,26" fill="#FFA726"/><polygon points="118,42 132,14 104,26" fill="#FFA726"/>
                            <polygon points="44,40 32,18 55,28" fill="#FF8A80"/><polygon points="116,40 128,18 105,28" fill="#FF8A80"/>
                            <circle cx="80" cy="72" r="46" fill="#FFA726"/>
                            <ellipse cx="80" cy="82" rx="28" ry="22" fill="#FFF8E1"/>
                            <path d="M66 34 Q72 26 80 34" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
                            <circle cx="62" cy="66" r="13" fill="white"/><circle cx="98" cy="66" r="13" fill="white"/>
                            {{-- Happy squinted eyes --}}
                            <path d="M54 66 Q62 58 70 66" stroke="#1a1a1a" stroke-width="4" fill="none" stroke-linecap="round"/>
                            <path d="M90 66 Q98 58 106 66" stroke="#1a1a1a" stroke-width="4" fill="none" stroke-linecap="round"/>
                            <ellipse cx="80" cy="82" rx="6" ry="4" fill="#E65100"/>
                            <path d="M70 89 Q80 100 90 89" stroke="#BF360C" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                            <circle cx="46" cy="78" r="11" fill="#FF8A80" opacity="0.5"/><circle cx="114" cy="78" r="11" fill="#FF8A80" opacity="0.5"/>
                            <line x1="28" y1="80" x2="58" y2="83" stroke="#8D6E63" stroke-width="1.2" opacity="0.6"/>
                            <line x1="28" y1="87" x2="58" y2="86" stroke="#8D6E63" stroke-width="1.2" opacity="0.6"/>
                            <line x1="102" y1="83" x2="132" y2="80" stroke="#8D6E63" stroke-width="1.2" opacity="0.6"/>
                            <line x1="102" y1="86" x2="132" y2="87" stroke="#8D6E63" stroke-width="1.2" opacity="0.6"/>
                            <ellipse cx="55" cy="154" rx="18" ry="13" fill="#FFA726"/><ellipse cx="105" cy="154" rx="18" ry="13" fill="#FFA726"/>
                            {{-- Raised paw --}}
                            <ellipse cx="118" cy="95" rx="14" ry="12" fill="#FFA726" transform="rotate(-30 118 95)"/>
                            <circle cx="112" cy="88" r="4.5" fill="#FFB300"/>
                            <circle cx="119" cy="85" r="4.5" fill="#FFB300"/>
                            <circle cx="126" cy="88" r="4.5" fill="#FFB300"/>
                        </svg>
                    </div>
                    <p style="font-size:1.1rem;margin-bottom:4px;"><span class="star-spin">&#11088;</span> <strong style="color:#92400e">Yêu!</strong> File đã sẵn sàng <span class="star-spin" style="animation-delay:.5s">&#11088;</span></p>
                    <p class="text-gray-400 text-sm mb-8 max-w-xs">Nhấn nút bên dưới để bắt đầu tải về — <strong class="text-green-600">miễn phí</strong> 🐯</p>

                    {{-- Download button --}}
                    <a href="{{ route('document.download', $document->slug) }}"
                       id="dl-btn"
                       class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-2xl font-bold text-white shadow-lg"
                       style="background:linear-gradient(135deg,#d97706,#92400e);">

                        {{-- Shimmer (overflow hidden on shimmer wrapper, not button) --}}
                        <span style="position:absolute;inset:0;border-radius:inherit;overflow:hidden;pointer-events:none;">
                            <span class="dl-shimmer"></span>
                        </span>

                        <span class="relative z-10 flex-shrink-0" style="width:2.25rem;height:2.25rem;border-radius:.75rem;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-download dl-arrow"></i>
                        </span>
                        <span class="relative z-10 text-left">
                            <span style="display:block;font-size:1.1rem;font-weight:900;line-height:1.2;white-space:nowrap;">Tải xuống miễn phí</span>
                            @if($document->file_size_kb)
                            <span style="display:block;font-size:.7rem;font-weight:400;opacity:.75;margin-top:2px;">{{ $document->file_size_formatted }} · {{ strtoupper($document->file_type) }}</span>
                            @endif
                        </span>
                    </a>

                    <p class="text-xs text-gray-400 mt-5 flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-green-400"></i>
                        Lưu trữ trên Google Drive — an toàn, không virus
                    </p>
                </div>

            </div>

            {{-- AD in-content --}}
            @include('components.ad-slot', ['key' => 'ad_slot_in_content'])

            {{-- Related --}}
            @if($relatedDocs->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-primary-400"></i>Tài liệu cùng chủ đề
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($relatedDocs as $related)
                    <x-document-card :document="$related" />
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- ===== SIDEBAR ===== --}}
        <div class="space-y-5">

            {{-- AD sidebar --}}
            @include('components.ad-slot', ['key' => 'ad_slot_sidebar'])

            {{-- File info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-primary-400"></i>Thông tin file
                </p>
                <dl class="space-y-0 text-sm divide-y divide-gray-50">
                    <div class="flex justify-between py-2.5">
                        <dt class="text-gray-400">Định dạng</dt>
                        <dd class="font-semibold text-gray-700 uppercase">{{ $document->file_type }}</dd>
                    </div>
                    @if($document->file_size_kb)
                    <div class="flex justify-between py-2.5">
                        <dt class="text-gray-400">Kích thước</dt>
                        <dd class="font-semibold text-gray-700">{{ $document->file_size_formatted }}</dd>
                    </div>
                    @endif
                    @if($document->page_count)
                    <div class="flex justify-between py-2.5">
                        <dt class="text-gray-400">Số trang</dt>
                        <dd class="font-semibold text-gray-700">{{ $document->page_count }} trang</dd>
                    </div>
                    @endif
                    <div class="flex justify-between py-2.5">
                        <dt class="text-gray-400">Lượt tải</dt>
                        <dd class="font-semibold text-gray-700">{{ number_format($document->download_count) }}</dd>
                    </div>
                    <div class="flex justify-between py-2.5">
                        <dt class="text-gray-400">Lượt xem</dt>
                        <dd class="font-semibold text-gray-700">{{ number_format($document->view_count) }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Back link --}}
            <a href="{{ route('document.show', $document->slug) }}"
               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl border border-gray-200 text-sm text-gray-500 hover:text-primary-700 hover:border-primary-200 hover:bg-primary-50 transition-all">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Quay lại trang tài liệu
            </a>

        </div>

    </div>
</div>
@endsection

@section('head')
<style>
/* Ring fill transition */
#countdown-ring {
    transition: stroke-dashoffset 1s linear, stroke .5s ease;
}

/* Number pop on each tick */
.num-tick {
    animation: numTick .3s cubic-bezier(.34,1.56,.64,1);
}
@keyframes numTick {
    0%   { transform: scale(.7); opacity: .5; }
    100% { transform: scale(1);  opacity: 1;  }
}

/* Ready state slide-in */
#ready-state {
    animation: slideUp .5s cubic-bezier(.22,1,.36,1) both;
}
@keyframes slideUp {
    from { opacity:0; transform: translateY(20px); }
    to   { opacity:1; transform: translateY(0); }
}

/* Success icon pop */
#success-icon {
    animation: iconPop .55s cubic-bezier(.34,1.56,.64,1) .1s both;
}
@keyframes iconPop {
    0%   { transform: scale(0); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

/* ===== CHIBI TIGER DECORATIONS ===== */
@keyframes tigerFloat {
    0%,100% { transform: translateY(0) rotate(-4deg); }
    50%      { transform: translateY(-14px) rotate(4deg); }
}
@keyframes tigerBlink {
    0%,88%,100% { transform: scaleY(1); }
    93%         { transform: scaleY(0.08); }
}
@keyframes tigerPeek {
    0%,100% { transform: translateX(0) rotate(-8deg); }
    50%      { transform: translateX(12px) rotate(5deg); }
}
@keyframes confettiFall {
    0%   { transform: translateY(-20px) rotate(0deg); opacity:1; }
    100% { transform: translateY(80px) rotate(360deg); opacity:0; }
}
@keyframes starPop {
    0%,100% { transform: scale(1) rotate(0deg); }
    50%      { transform: scale(1.4) rotate(20deg); }
}
.deco-tiger { pointer-events:none; position:absolute; }
.tiger-float { animation: tigerFloat 3s ease-in-out infinite; }
.tiger-peek  { animation: tigerPeek 2.5s ease-in-out infinite; }
.tiger-eye-anim { animation: tigerBlink 4s ease-in-out infinite; transform-box: fill-box; transform-origin: center; }
.confetti-piece { position:absolute; border-radius:2px; animation: confettiFall 1.2s ease-in both; }
.star-spin { animation: starPop 1.8s ease-in-out infinite; display:inline-block; }

/* Download button */
#dl-btn {
    transition: transform .18s ease, box-shadow .18s ease;
}
#dl-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 36px -8px rgba(146,64,14,.45);
}
#dl-btn:active {
    transform: translateY(1px);
    box-shadow: 0 4px 12px -4px rgba(146,64,14,.4);
}

/* Download icon bounce */
.dl-arrow {
    animation: dlBounce 1.2s ease-in-out 1.5s infinite;
}
@keyframes dlBounce {
    0%,100% { transform: translateY(0); }
    45%     { transform: translateY(5px); }
    70%     { transform: translateY(-2px); }
}

/* Shimmer sweep */
.dl-shimmer {
    position: absolute; inset: 0;
    background: linear-gradient(105deg, transparent 35%, rgba(255,255,255,.22) 50%, transparent 65%);
    background-size: 250% 100%;
    animation: shimmer 2.8s linear 2s infinite;
    pointer-events: none;
}
@keyframes shimmer {
    0%   { background-position: 250% 0; }
    100% { background-position: -250% 0; }
}

/* Animated dots */
.dot { display: inline-block; animation: dotFade 1.2s ease-in-out infinite; }
.dot:nth-child(2) { animation-delay: .2s; }
.dot:nth-child(3) { animation-delay: .4s; }
@keyframes dotFade { 0%,80%,100% { opacity:.2; } 40% { opacity:1; } }
</style>
@endsection

@section('scripts')
<script>
(function () {
    const TOTAL  = 10;
    const CIRC   = 427.3; // 2π × 68

    const ring    = document.getElementById('countdown-ring');
    const numEl   = document.getElementById('countdown-number');
    const waiting = document.getElementById('waiting-state');
    const ready   = document.getElementById('ready-state');
    const bar     = document.getElementById('progress-bar');

    let remaining = TOTAL;

    // Start ring empty
    ring.style.strokeDashoffset = CIRC;

    function tick() {
        remaining--;

        // Number pop
        numEl.classList.remove('num-tick');
        void numEl.offsetWidth;
        numEl.classList.add('num-tick');
        numEl.textContent = remaining > 0 ? remaining : '';

        // Fill ring from 0% → 100% as time elapses
        const elapsed = TOTAL - remaining;
        ring.style.strokeDashoffset = CIRC - (elapsed / TOTAL) * CIRC;

        // Progress bar
        bar.style.width = (elapsed / TOTAL * 100) + '%';

        // Colour at 3s left
        if (remaining === 3) {
            ring.style.stroke = '#d97706';
        }
        if (remaining === 1) {
            ring.style.stroke = '#16a34a';
        }

        if (remaining <= 0) {
            waiting.classList.add('hidden');
            ready.classList.remove('hidden');
            // 🎉 Confetti burst
            spawnConfetti();
        } else {
            setTimeout(tick, 1000);
        }
    }

    function spawnConfetti() {
        const box = document.getElementById('confetti-box');
        if (!box) return;
        const colors = ['#FFA726','#84cc16','#f472b6','#60a5fa','#facc15','#34d399','#f87171'];
        for (let i = 0; i < 28; i++) {
            const el = document.createElement('div');
            el.className = 'confetti-piece';
            const size = 6 + Math.random() * 8;
            el.style.cssText = `
                width:${size}px; height:${size * (Math.random() > .5 ? 2.5 : 1)}px;
                background:${colors[Math.floor(Math.random()*colors.length)]};
                left:${10 + Math.random()*80}%;
                top:0;
                border-radius:${Math.random()>.5?'50%':'3px'};
                animation-delay:${Math.random()*0.6}s;
                animation-duration:${1 + Math.random()*0.8}s;
            `;
            box.appendChild(el);
            setTimeout(() => el.remove(), 2200);
        }
    }

    // Animated dots
    const dotsEl = document.getElementById('dots');
    let dotCount = 0;
    setInterval(() => {
        dotCount = (dotCount + 1) % 4;
        dotsEl.textContent = '.'.repeat(dotCount);
    }, 400);

    setTimeout(tick, 1000);
})();
</script>
@endsection
