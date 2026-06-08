{{-- 語言切換器：連到目前頁面的對應語系版本。沿用 navbar 既有的 dropdown 樣式 --}}
@php
    $baseName = frontend_base_route_name('frontend.home');
    $routeParams = request()->route()
        ? collect(request()->route()->parameters())->except('locale')->all()
        : [];
    $locales = \App\Support\LocaleService::all();
    $current = $locales->firstWhere('code', app()->getLocale());
@endphp
@if($locales->count() > 1)
<li class="lang-switcher">
    <a href="#" class="nav-link">
        <i class="fas fa-globe"></i>
        {{ $current->native_name ?? app()->getLocale() }}
        <i class="fas fa-chevron-down dropdown-icon"></i>
    </a>
    <div class="dropdown-menu">
        @foreach($locales as $loc)
        {{-- 走 /lang 端點：設偏好 cookie（覆寫自動偵測）並導回同頁該語系版本 --}}
        <a href="{{ route('frontend.lang', ['code' => $loc->code]) }}?route={{ $baseName }}"
           class="dropdown-item {{ $loc->code === app()->getLocale() ? 'active' : '' }}">
            {{ $loc->native_name }}
        </a>
        @endforeach
    </div>
</li>
@endif
