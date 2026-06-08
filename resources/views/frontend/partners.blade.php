@extends('frontend.layouts.app')

@section('title', '關係企業 | 楷懿國際投資')
@section('meta_description', '楷懿國際投資的集團企業與合作夥伴，整合集團資源、創造綜效價值。')
@section('meta_keywords', '楷懿關係企業,集團企業,合作夥伴,集團資源整合')
@section('canonical', 'https://kaiyiinvest.com/partners.html')

@section('og_title', '關係企業 | 楷懿國際投資')
@section('og_description', '楷懿國際投資的集團企業與合作夥伴，整合集團資源、創造綜效價值。')

@section('twitter_title', '關係企業 | 楷懿國際投資')
@section('twitter_description', '楷懿國際投資的集團企業與合作夥伴，整合集團資源、創造綜效價值。')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/partners.css') }}?v=20260605">
@endpush

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-bg"
            style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920&q=80');">
        </div>
        <div class="page-header-overlay"></div>
        <div class="page-header-content">
            <h1>{{ cb('partners','header.title') }}</h1>
            <p>{{ cb('partners','header.subtitle') }}</p>
        </div>
    </section>

    <!-- Partners Diagram Section -->
    <section class="section partners-diagram-section">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('partners','section.subtitle') }}</p>
                <h2 class="section-title">{{ cb('partners','section.title') }}</h2>
            </div>

            <div class="partners-diagram">
                <!-- Center -->
                <div class="partner-center">
                    <div class="partner-logo-circle">
                        <img src="{{ asset('assets/img/logo/logo.png') }}" alt="楷懿國際投資">
                    </div>
                    <h3>{{ cb('partners','center.name') }}</h3>
                    <p>{{ cb('partners','center.desc') }}</p>
                </div>

                <!-- Partner 1 -->
                <div class="partner-item partner-1">
                    <a class="partner-card" href="https://www.kaiyi-car.com.tw/" target="_blank" rel="noopener">
                        <div class="partner-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h4>{{ cb('partners','partner1.name') }}</h4>
                        <p>{{ cb('partners','partner1.desc') }}</p>
                    </a>
                </div>

                <!-- Partner 2 -->
                <div class="partner-item partner-2">
                    <a class="partner-card" href="https://kaiyi-vip.com/" target="_blank" rel="noopener">
                        <div class="partner-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4>{{ cb('partners','partner2.name') }}</h4>
                        <p>{{ cb('partners','partner2.desc') }}</p>
                    </a>
                </div>

                <!-- Partner 3 -->
                <div class="partner-item partner-3">
                    <a class="partner-card" href="https://www.kaiyieyelash.com/" target="_blank" rel="noopener">
                        <div class="partner-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4>{{ cb('partners','partner3.name') }}</h4>
                        <p>{{ cb('partners','partner3.desc') }}</p>
                    </a>
                </div>

                <!-- Partner 4 -->
                <div class="partner-item partner-4">
                    <a class="partner-card" href="{{ route('frontend.home') }}">
                        <div class="partner-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4>{{ cb('partners','partner4.name') }}</h4>
                        <p>{{ cb('partners','partner4.desc') }}</p>
                    </a>
                </div>

                <!-- Partner 5 https://kaiyirealestate.com/ -->
                <div class="partner-item partner-5">
                    <a class="partner-card" id="digitalMarketingTrigger" role="button" tabindex="0"
                        data-video="{{ asset('assets/img/partners/802232140.601835.mp4') }}">
                        <div class="partner-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h4>{{ cb('partners','partner5.name') }}</h4>
                        <p>{{ cb('partners','partner5.desc') }}</p>
                    </a>
                </div>

                <!-- Connection Lines -->
                <svg class="connection-lines" viewBox="0 0 800 850">
                    <!-- 中心到上方 (Partner 1 底部) - 更長的距離 -->
                    <line x1="400" y1="425" x2="400" y2="130" stroke="#C9A961" stroke-width="2" opacity="0.3" />
                    <!-- 中心到右上 (Partner 2 左側) -->
                    <line x1="400" y1="425" x2="640" y2="265" stroke="#C9A961" stroke-width="2" opacity="0.3" />
                    <!-- 中心到右下 (Partner 3 左上角) -->
                    <line x1="400" y1="425" x2="590" y2="600" stroke="#C9A961" stroke-width="2" opacity="0.3" />
                    <!-- 中心到左下 (Partner 4 右上角) -->
                    <line x1="400" y1="425" x2="210" y2="600" stroke="#C9A961" stroke-width="2" opacity="0.3" />
                    <!-- 中心到左上 (Partner 5 右側) -->
                    <line x1="400" y1="425" x2="160" y2="265" stroke="#C9A961" stroke-width="2" opacity="0.3" />
                </svg>
            </div>
        </div>
    </section>

    <!-- Video Modal（楷懿數位行銷）-->
    <div class="video-modal" id="videoModal" role="dialog" aria-modal="true" aria-label="楷懿數位行銷影片">
        <div class="video-modal-overlay"></div>
        <div class="video-modal-content">
            <button class="video-modal-close" id="videoModalClose" aria-label="關閉影片">
                <i class="fas fa-times"></i>
            </button>
            <!-- src 由 JS 在開啟時才設定，避免頁面載入即下載影片 -->
            <video id="modalVideo" controls playsinline preload="none"></video>
        </div>
    </div>
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
      "telephone": [
        "+886987773519",
        "+84768168989"
      ],
      "areaServed": [
        {
          "@type": "Country",
          "name": "Vietnam"
        },
        {
          "@type": "Country",
          "name": "Taiwan"
        }
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
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "首頁",
          "item": "https://kaiyiinvest.com/index.html"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "關係企業",
          "item": "https://kaiyiinvest.com/partners.html"
        }
      ]
    }
    </script>
@endpush
