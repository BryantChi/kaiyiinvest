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
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/img/hero/hero.mp4') }}" type="video/mp4">
        </video>
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

