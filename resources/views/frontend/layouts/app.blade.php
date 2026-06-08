<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- SEO：DB 的 page_seo()（每頁每語系）覆寫各頁靜態 @section 預設；皆無則用預設 --}}
    @php
        $seo = page_seo();
        $defLogo = asset('assets/img/logo/logo.png');
        $seoTitle = ($seo?->meta_title ?: null) ?: trim($__env->yieldContent('title', '楷懿國際投資 | Kaiyi International Investment'));
        $seoDesc = ($seo?->meta_description ?: null) ?: trim($__env->yieldContent('meta_description', '楷懿國際投資專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。'));
        $seoKeywords = ($seo?->meta_keywords ?: null) ?: trim($__env->yieldContent('meta_keywords', '楷懿國際投資,越南不動產,工業地產,工業區開發招商,包租代管,不動產代理,越南房地產投資,河內,海防'));
        $seoRobots = ($seo?->meta_robots ?: null) ?: 'index, follow, max-image-preview:large';
        $seoCanonical = ($seo?->canonical_url ?: null) ?: url()->current();
        $ogTitle = ($seo?->og_title ?: null) ?: trim($__env->yieldContent('og_title', $seoTitle));
        $ogDesc = ($seo?->og_description ?: null) ?: trim($__env->yieldContent('og_description', $seoDesc));
        $ogImage = $seo?->og_image ? (\Illuminate\Support\Str::startsWith($seo->og_image, ['http', '//']) ? $seo->og_image : asset($seo->og_image)) : trim($__env->yieldContent('og_image', $defLogo));
        $twTitle = ($seo?->twitter_title ?: null) ?: trim($__env->yieldContent('twitter_title', $ogTitle));
        $twDesc = ($seo?->twitter_description ?: null) ?: trim($__env->yieldContent('twitter_description', $ogDesc));
        $twImage = $seo?->twitter_image ? (\Illuminate\Support\Str::startsWith($seo->twitter_image, ['http', '//']) ? $seo->twitter_image : asset($seo->twitter_image)) : $ogImage;
    @endphp
    <title>{{ $seoTitle }}</title>

    {{-- SEO Meta --}}
    <meta name="description" content="{{ $seoDesc }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="楷懿國際投資">
    <meta name="robots" content="{{ $seoRobots }}">
    <link rel="canonical" href="{{ $seoCanonical }}">

    {{-- hreflang：依啟用語系自動產生目前頁面的各語系版本 --}}
    @include('frontend.partials.hreflang')

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="楷懿國際投資 Kaiyi International Investment">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDesc }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'zh-TW' ? 'zh_TW' : str_replace('-', '_', app()->getLocale()) }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ $seo?->twitter_card ?: 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $twTitle }}">
    <meta name="twitter:description" content="{{ $twDesc }}">
    <meta name="twitter:image" content="{{ $twImage }}">

    {{-- 其他 --}}
    <meta name="theme-color" content="#0A0A0A">
    <link rel="icon" href="{{ asset('assets/img/logo/logo.png') }}">

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;700&family=Cinzel:wght@400;600;700&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v=20260605">
    @stack('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/enhancements.css') }}?v=20260605">
    @stack('head')
</head>

<body>
    {{-- Page Loader --}}
    <div class="page-loader">
        <div class="loader-logo">KAIYI</div>
        <div class="loader-spinner"></div>
        <div class="loader-text">Loading...</div>
    </div>

    @include('frontend.partials.navbar')

    @yield('content')

    {{-- footer：原首頁未顯示 footer，故由 $hideFooter 控制（遵守「未顯示維持隱藏」） --}}
    @unless($hideFooter ?? false)
        @include('frontend.partials.footer')
    @endunless

    {{-- Back to Top --}}
    <button id="backToTop" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="{{ asset('assets/js/main.js') }}?v=20260605"></script>
    @stack('page-js')

    {{-- Structured Data (JSON-LD)：頁面靜態基準 + 後台每頁每語系可編輯的補充 --}}
    @stack('structured-data')
    @if($seo && $seo->schema_org)
    <script type="application/ld+json">{!! $seo->schema_org_json !!}</script>
    @endif
</body>

</html>
