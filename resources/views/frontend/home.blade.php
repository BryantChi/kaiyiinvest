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

@push('structured-data')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "RealEstateAgent",
      "@id": "https://kaiyiinvest.com/#organization",
      "name": "楷懿國際投資",
      "alternateName": "Kaiyi International Investment",
      "url": "https://kaiyiinvest.com/",
      "logo": "https://kaiyiinvest.com/assets/img/logo/logo.png",
      "image": "https://kaiyiinvest.com/assets/img/logo/logo.png",
      "email": "kaiyiinvest@gmail.com",
      "description": "楷懿國際投資專注工業地產、不動產代理與專業諮詢，深耕越南河內、海防市場，提供工業區開發招商、包租代管與跨國不動產投資服務。",
      "telephone": ["+886987773519", "+84768168989"],
      "areaServed": [
        { "@type": "Country", "name": "Vietnam" },
        { "@type": "Country", "name": "Taiwan" }
      ],
      "address": [
        {
          "@type": "PostalAddress",
          "streetAddress": "SB01-SP.02-18, Sao Bien Subdivision, Vinhomes Ocean Park Urban Area",
          "addressLocality": "Gia Lam, Hanoi",
          "addressCountry": "VN"
        },
        {
          "@type": "PostalAddress",
          "streetAddress": "So 449, Vo Nguyen Giap, Phuong Kenh Duong, Quan Le Chan",
          "addressLocality": "Hai Phong",
          "addressCountry": "VN"
        }
      ],
      "hasMap": [
        "https://maps.app.goo.gl/UH9iwxsFqonbLx2D8?g_st=il",
        "https://maps.app.goo.gl/1r2e87E8h971Kisu7?g_st=il"
      ],
      "sameAs": []
    }
    </script>
    <!-- sameAs 待業主提供 FB / IG / Google 商家網址後填入；查無公開檔案，勿編造 -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "@id": "https://kaiyiinvest.com/#website",
      "url": "https://kaiyiinvest.com/",
      "name": "楷懿國際投資 Kaiyi International Investment",
      "inLanguage": "zh-TW",
      "publisher": { "@id": "https://kaiyiinvest.com/#organization" }
    }
    </script>
@endpush
