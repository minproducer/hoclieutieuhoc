@php
    $adCode = \App\Models\Setting::get($key ?? '', '');
@endphp
@if($adCode)
<div class="ad-slot-wrapper max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 text-center">
    {!! $adCode !!}
</div>
@endif
