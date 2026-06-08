@extends('frontend.layouts.app')

@section('title', '常見問題 | 楷懿國際投資')
@section('meta_description', '楷懿不動產常見問題 — 簽約、產權、稅費、貸款、外國人購屋等專業解答。')
@section('meta_keywords', '不動產常見問題,購屋FAQ,房地產稅費,購屋貸款,外國人購屋,產權')
@section('canonical', 'https://kaiyiinvest.com/faq.html')

@section('og_title', '常見問題 | 楷懿國際投資')
@section('og_description', '楷懿不動產常見問題 — 簽約、產權、稅費、貸款、外國人購屋等專業解答。')

@section('twitter_title', '常見問題 | 楷懿國際投資')
@section('twitter_description', '楷懿不動產常見問題 — 簽約、產權、稅費、貸款、外國人購屋等專業解答。')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/faq.css') }}?v=20260605">
@endpush

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-bg"
            style="background-image: url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1920&q=80');">
        </div>
        <div class="page-header-overlay"></div>
        <div class="page-header-content">
            <h1>{{ cb('faq', 'header.title') }}</h1>
            <p>{{ cb('faq', 'header.subtitle') }}</p>
            <div class="breadcrumb">
                <a href="{{ route('frontend.home') }}">首頁</a>
                <span>/</span>
                <a href="{{ route('frontend.services') }}">服務項目</a>
                <span>/</span>
                <span>常見問題</span>
            </div>
        </div>
    </section>

    <!-- FAQ Intro -->
    <section class="section faq-intro">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('faq', 'intro.subtitle') }}</p>
                <h2 class="section-title">{{ cb('faq', 'intro.title') }}</h2>
                <p class="section-description">
                    {!! cb('faq', 'intro.description') !!}
                </p>
            </div>
        </div>
    </section>

    <!-- FAQ Categories -->
    <section class="section faq-categories">
        <div class="container">
            <div class="categories-grid">
                <button class="category-btn active" data-category="all">
                    <i class="fas fa-th"></i>
                    <span>{{ cb('faq', 'filter.all') }}</span>
                </button>
                <button class="category-btn" data-category="contract">
                    <i class="fas fa-file-contract"></i>
                    <span>{{ cb('faq', 'filter.contract') }}</span>
                </button>
                <button class="category-btn" data-category="tax">
                    <i class="fas fa-calculator"></i>
                    <span>{{ cb('faq', 'filter.tax') }}</span>
                </button>
                <button class="category-btn" data-category="ownership">
                    <i class="fas fa-key"></i>
                    <span>{{ cb('faq', 'filter.ownership') }}</span>
                </button>
                <button class="category-btn" data-category="finance">
                    <i class="fas fa-coins"></i>
                    <span>{{ cb('faq', 'filter.finance') }}</span>
                </button>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion -->
    <section class="section faq-section">
        <div class="container">
            <div class="faq-accordion">
                @forelse($faqs as $faq)
                    @php $t = $faq->translation(); @endphp
                    <div class="faq-item" data-category="{{ $faq->category }}">
                        <div class="faq-question">
                            <h3>{{ $t?->question }}</h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">{!! $t?->answer !!}</div>
                    </div>
                @empty
                    <p>目前沒有常見問題。</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>{{ cb('faq', 'cta.title') }}</h2>
                <p>{{ cb('faq', 'cta.subtitle') }}</p>
                <div class="cta-buttons">
                    <a href="{{ route('frontend.contact') }}" class="btn btn-primary">
                        <i class="fas fa-phone"></i>
                        立即諮詢
                    </a>
                    <a href="{{ route('frontend.services') }}" class="btn btn-secondary">
                        <i class="fas fa-briefcase"></i>
                        查看服務
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('page-js')
    <script src="{{ asset('assets/js/faq.js') }}?v=20260605"></script>
@endpush

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
          "name": "常見問題",
          "item": "https://kaiyiinvest.com/faq.html"
        }
      ]
    }
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "簽約時需要注意哪些合約類型？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "不動產交易主要涉及兩種合約：定金合約（預約合約），買賣雙方初步達成交易意向時簽訂，需支付總價5-10%定金；買賣合約（正式合約），完成產權調查與貸款審核後簽訂，具完整法律效力。建議簽約前請專業代書或律師審閱。"
          }
        },
        {
          "@type": "Question",
          "name": "購買不動產需要準備哪些文件？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "基本文件包含身分證明（身分證或護照）、印鑑證明與印鑑章、戶籍謄本、財力證明、收入證明。外國人另需準備居留證明或入境簽證。"
          }
        },
        {
          "@type": "Question",
          "name": "購買不動產需要繳納哪些稅費？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "主要包含契稅（房地總價6%）、印花稅（契價0.1%）、登記規費、代書費、火險與地震險。實際稅額依物件類型、地區與價格而異。"
          }
        },
        {
          "@type": "Question",
          "name": "出售不動產時需要繳納什麼稅？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "主要涉及房地合一稅（依持有期間與所得，稅率15%-45%）、土地增值稅（20%-40%）、財產交易所得稅。自住房地符合條件者可申請優惠稅率或免稅。"
          }
        },
        {
          "@type": "Question",
          "name": "如何計算房屋的實際面積？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "分登記面積（權狀面積，含主建物、附屬建物與公設）與室內實際使用面積（扣除公設與陽台，約為登記面積60-75%）。公設比越高，實際使用占比越低。"
          }
        },
        {
          "@type": "Question",
          "name": "外國人可以在台灣購買不動產嗎？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "可以。須取得內政部許可，購買土地有面積與用途限制，特定區域（如軍事管制區）禁止外國人購買，大陸地區人民另有特別規定。本公司提供外國人購屋專業諮詢。"
          }
        },
        {
          "@type": "Question",
          "name": "不動產產權的有效期限是多久？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "台灣土地與建物所有權均為永久產權，無期限限制；地上權依契約約定年限，期滿可申請續約。台灣採土地與建物分別登記制度。"
          }
        },
        {
          "@type": "Question",
          "name": "購屋可以申請銀行貸款嗎？最高可貸多少成數？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "可以。一般為房價7-8成，最高約8.5成；貸款年限最長30-40年；利率約1.8%-2.5%（機動計息）；需有穩定收入與良好信用，負債比不超過月收入60%。"
          }
        },
        {
          "@type": "Question",
          "name": "資金如何安全地進出與轉移？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "建議透過銀行匯款、銀行本票、履約保證專戶、信託專戶等安全管道。避免現金交易，所有款項保留完整憑證，並依法申報以符合洗錢防制規定。"
          }
        },
        {
          "@type": "Question",
          "name": "首次購屋有什麼優惠方案嗎？",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "可享青年安心成家購屋優惠貸款、財政部青年首購低利貸款、各縣市首購補助、銀行首購專案等。各方案申請條件與名額有限，建議及早規劃並向本公司諮詢最新方案。"
          }
        }
      ]
    }
    </script>
@endpush
