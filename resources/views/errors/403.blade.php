@extends('errors.layout')

@section('title', '403 — Không có quyền truy cập')
@section('code', '403')
@section('heading', 'Bạn không được phép vào đây!')
@section('message', 'Hổ con đứng chặn cửa rồi! Khu vực này chỉ dành cho người có quyền truy cập thôi nhé 🐯🚧')

@section('tiger-eyes')
    {{-- Stern/serious eyes - looking straight, narrowed --}}
    <g class="tiger-eye">
        <ellipse cx="60" cy="66" rx="9" ry="7" fill="#1a1a1a"/>
        <circle cx="57" cy="63" r="3" fill="white"/>
        {{-- Eyebrow furrowed --}}
        <path d="M50 57 Q60 53 70 57" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
    </g>
    <g class="tiger-eye" style="animation-delay:.7s">
        <ellipse cx="98" cy="66" rx="9" ry="7" fill="#1a1a1a"/>
        <circle cx="95" cy="63" r="3" fill="white"/>
        <path d="M88 57 Q98 53 108 57" stroke="#E65100" stroke-width="3" fill="none" stroke-linecap="round"/>
    </g>
@endsection

@section('tiger-mouth')
    {{-- Flat/serious mouth --}}
    <path d="M73 88 L87 88" stroke="#BF360C" stroke-width="2.5" stroke-linecap="round"/>
@endsection

@section('tiger-extra')
    {{-- Stop sign / warning badge --}}
    <circle cx="128" cy="38" r="16" fill="#ef4444" opacity="0.9"/>
    <line x1="120" y1="38" x2="136" y2="38" stroke="white" stroke-width="4" stroke-linecap="round"/>
@endsection
