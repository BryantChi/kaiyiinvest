{{-- 依啟用語系產生目前頁面的 hreflang 替代連結 + x-default --}}
@php
    $baseName = frontend_base_route_name(null);
    $routeParams = request()->route()
        ? collect(request()->route()->parameters())->except('locale')->all()
        : [];
@endphp
@if($baseName)
    @foreach(\App\Support\LocaleService::all() as $loc)
        <link rel="alternate" hreflang="{{ $loc->code }}" href="{{ localized_route($baseName, $routeParams, $loc->code) }}">
        @if($loc->is_default)
        <link rel="alternate" hreflang="x-default" href="{{ localized_route($baseName, $routeParams, $loc->code) }}">
        @endif
    @endforeach
@endif
