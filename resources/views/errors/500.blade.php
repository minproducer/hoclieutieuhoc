@extends('errors.layout')

@section('title', '500 — Lỗi máy chủ')
@section('code', '500')
@section('heading', 'Ôi, máy chủ bị ngã rồi!')
@section('message', 'Hổ con vô tình làm đổ cả server rồi... Đội ngũ đang dọn dẹp, bạn thử lại sau nhé 🐯')

@section('tiger-eyes')
    {{-- Dizzy cross eyes --}}
    <g class="tiger-eye">
        <line x1="55" y1="61" x2="65" y2="71" stroke="#1a1a1a" stroke-width="3.5" stroke-linecap="round"/>
        <line x1="65" y1="61" x2="55" y2="71" stroke="#1a1a1a" stroke-width="3.5" stroke-linecap="round"/>
    </g>
    <g class="tiger-eye" style="animation-delay:.3s">
        <line x1="91" y1="61" x2="101" y2="71" stroke="#1a1a1a" stroke-width="3.5" stroke-linecap="round"/>
        <line x1="101" y1="61" x2="91" y2="71" stroke="#1a1a1a" stroke-width="3.5" stroke-linecap="round"/>
    </g>
@endsection

@section('tiger-mouth')
    {{-- Wavy shocked mouth --}}
    <path d="M72 88 Q76 94 80 88 Q84 94 88 88" stroke="#BF360C" stroke-width="2.5" fill="none" stroke-linecap="round"/>
@endsection

@section('tiger-extra')
    {{-- Stars from dizzy --}}
    <text x="30" y="28" font-size="14" opacity="0.7" style="animation:starPop 1.5s ease-in-out infinite">⭐</text>
    <text x="112" y="32" font-size="12" opacity="0.6" style="animation:starPop 1.5s ease-in-out .4s infinite">💫</text>
    <text x="68" y="18" font-size="11" opacity="0.5" style="animation:starPop 1.5s ease-in-out .8s infinite">✨</text>
@endsection

@section('head')
@parent
<style>
@keyframes starPop { 0%,100%{transform:scale(1) rotate(0deg)} 50%{transform:scale(1.4) rotate(25deg)} }
</style>
@endsection
