@extends('errors.layout')

@section('title', '404 — Không tìm thấy trang')
@section('code', '404')
@section('heading', 'Trang này đi đâu mất rồi!')
@section('message', 'Hổ con tìm mãi không thấy trang bạn yêu cầu. Có thể đường dẫn bị sai hoặc trang đã bị xoá rồi 🐯')

@section('tiger-eyes')
    {{-- Sad/searching eyes (look left) --}}
    <g class="tiger-eye"><circle cx="60" cy="65" r="9" fill="#1a1a1a"/><circle cx="57" cy="62" r="3" fill="white"/></g>
    <g class="tiger-eye" style="animation-delay:.5s"><circle cx="96" cy="65" r="9" fill="#1a1a1a"/><circle cx="93" cy="62" r="3" fill="white"/></g>
@endsection

@section('tiger-mouth')
    {{-- Sad mouth --}}
    <path d="M73 90 Q80 85 87 90" stroke="#BF360C" stroke-width="2" fill="none" stroke-linecap="round"/>
@endsection

@section('tiger-extra')
    {{-- Sweat drop --}}
    <ellipse cx="108" cy="48" rx="5" ry="7" fill="#93c5fd" opacity="0.9"/>
    <path d="M108 41 Q112 46 108 55 Q104 46 108 41" fill="#93c5fd" opacity="0.9"/>
    {{-- Question marks floating --}}
@endsection
