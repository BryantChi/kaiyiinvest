@extends('frontend.layouts.app')

@section('title', '楷懿國際投資 | Kaiyi International Investment')
@section('meta_description', '楷懿國際投資專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。')
@section('meta_keywords', '楷懿國際投資,越南不動產,工業地產,工業區開發招商,包租代管,不動產代理,越南房地產投資,河內,海防')
@section('canonical', 'https://kaiyiinvest.com/index.html')

@section('og_title', '楷懿國際投資 | Kaiyi International Investment')
@section('og_description', '楷懿國際投資專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。')

@section('twitter_title', '楷懿國際投資 | Kaiyi International Investment')
@section('twitter_description', '楷懿國際投資專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        {{-- poster 讓首屏瞬間顯示完整畫面；影片以 metadata 預載、faststart 邊下邊播。
             手機載 720p 13MB 版、桌機載無損版，src 由下方 JS 依視窗寬度選擇（避免兩支都下載）。 --}}
        <video class="hero-video" autoplay muted loop playsinline preload="metadata"
               poster="{{ asset('assets/img/hero/hero-poster.jpg') }}?v=20260608"
               data-src-desktop="{{ asset('assets/img/hero/hero.mp4') }}?v=20260608"
               data-src-mobile="{{ asset('assets/img/hero/hero-mobile.mp4') }}?v=20260608"></video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">{{ cb('home', 'hero.title') }}<br><span class="text-gold">{{ cb('home', 'hero.title_highlight') }}</span></h1>
            <p class="hero-subtitle">{{ cb('home', 'hero.subtitle') }}</p>
            <div class="hero-buttons">
                <a href="{{ localized_route('frontend.services') }}" class="btn btn-primary">{{ cb('home', 'hero.btn_primary') }}</a>
                <a href="{{ localized_route('frontend.contact') }}" class="btn btn-outline">{{ cb('home', 'hero.btn_outline') }}</a>
            </div>
        </div>
    </section>
@endsection

@push('page-js')
<script>
    // 依視窗寬度載入對應 hero 影片來源：手機(<=768px)用輕量版，桌機用無損版。
    // 只設定被選中的那一支，避免另一支也被下載。
    (function () {
        var v = document.querySelector('.hero-video');
        if (!v) return;
        var isMobile = window.matchMedia('(max-width: 768px)').matches;
        v.src = isMobile ? v.dataset.srcMobile : v.dataset.srcDesktop;
        v.load();
    })();
</script>
@endpush

