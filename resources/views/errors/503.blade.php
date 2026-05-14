@extends('errors.layout')

@section('title', '503 — Bảo trì hệ thống')
@section('code', '503')
@section('heading', 'Đang bảo trì, tí quay lại nhé!')
@section('message', 'Hổ con đang ngủ để lấy sức bảo trì hệ thống. Bạn quay lại sau chút xíu nha 💤')

@section('tiger-eyes')
    {{-- Sleeping closed eyes (curved lines) --}}
    <path d="M52 66 Q60 61 68 66" stroke="#1a1a1a" stroke-width="3" fill="none" stroke-linecap="round"/>
    <path d="M88 66 Q96 61 104 66" stroke="#1a1a1a" stroke-width="3" fill="none" stroke-linecap="round"/>
@endsection

@section('tiger-mouth')
    {{-- Sleeping slightly open mouth --}}
    <path d="M75 88 Q80 92 85 88" stroke="#BF360C" stroke-width="2" fill="none" stroke-linecap="round"/>
@endsection

@section('tiger-extra')
    {{-- Zzz bubbles --}}
    <text x="115" y="46" font-size="13" fill="#6366f1" font-weight="900" opacity="0.8" style="animation:zFloat 2s ease-in-out infinite">Z</text>
    <text x="124" y="32" font-size="17" fill="#8b5cf6" font-weight="900" opacity="0.7" style="animation:zFloat 2s ease-in-out .5s infinite">Z</text>
    <text x="136" y="16" font-size="22" fill="#a78bfa" font-weight="900" opacity="0.6" style="animation:zFloat 2s ease-in-out 1s infinite">Z</text>
@endsection

@section('head')
@parent
<style>
@keyframes zFloat { 0%{transform:translateY(0) scale(1);opacity:.8} 100%{transform:translateY(-20px) scale(1.3);opacity:0} }
</style>
@endsection
