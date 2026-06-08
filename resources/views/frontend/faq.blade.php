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

