@extends('errors.layout')

@section('title', '419 — Phiên làm việc hết hạn')
@section('code', '419')
@section('heading', 'Phiên đăng nhập hết hạn rồi!')
@section('message', 'Hổ con ngủ quên mất, phiên làm việc của bạn đã hết hạn. Vui lòng tải lại trang hoặc đăng nhập lại nhé 🐯⏰')

@section('tiger-eyes')
    {{-- Sleepy/apologetic half-closed eyes --}}
    <g class="tiger-eye">
        <circle cx="60" cy="68" r="9" fill="#1a1a1a"/>
        <circle cx="57" cy="65" r="3" fill="white"/>
        {{-- Half-lid --}}
        <path d="M51 64 Q60 58 69 64" fill="#FFA726"/>
    </g>
    <g class="tiger-eye" style="animation-delay:.6s">
        <circle cx="98" cy="68" r="9" fill="#1a1a1a"/>
        <circle cx="95" cy="65" r="3" fill="white"/>
        <path d="M89 64 Q98 58 107 64" fill="#FFA726"/>
    </g>
@endsection

@section('tiger-mouth')
    {{-- Apologetic mouth --}}
    <path d="M73 88 Q80 84 87 88" stroke="#BF360C" stroke-width="2" fill="none" stroke-linecap="round"/>
@endsection

@section('tiger-extra')
    {{-- Clock icon --}}
    <circle cx="32" cy="38" r="16" fill="none" stroke="#f59e0b" stroke-width="3" opacity="0.8"/>
    <line x1="32" y1="28" x2="32" y2="38" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round"/>
    <line x1="32" y1="38" x2="40" y2="42" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round"/>
    <circle cx="32" cy="38" r="2.5" fill="#f59e0b"/>
@endsection

@section('action-buttons')
<div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
    <a href="{{ url()->previous() }}" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:#3a6b00;color:white;border-radius:1rem;font-weight:800;text-decoration:none;font-size:.95rem;box-shadow:0 4px 18px -4px rgba(58,107,0,.4);">
        <i class="fa-solid fa-rotate-right"></i> Tải lại trang
    </a>
    <a href="{{ url('/') }}" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.5rem;background:white;color:#374151;border:2px solid #d1fae5;border-radius:1rem;font-weight:700;text-decoration:none;font-size:.95rem;">
        <i class="fa-solid fa-house"></i> Về trang chủ
    </a>
</div>
@endsection
