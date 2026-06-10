@extends('frontend.layouts.app')

@section('title', '關於我們 | 楷懿國際投資')
@section('meta_description', '認識楷懿國際投資的企業理念、公司沿革與專業團隊，以「專業・責任・價值」服務跨國不動產投資客戶。')
@section('meta_keywords', '楷懿國際投資,關於我們,企業理念,公司沿革,專業團隊,不動產投資顧問')
@section('canonical', 'https://kaiyiinvest.com/about.html')

@section('og_title', '關於我們 | 楷懿國際投資')
@section('og_description', '認識楷懿國際投資的企業理念、公司沿革與專業團隊，以「專業・責任・價值」服務跨國不動產投資客戶。')

@section('twitter_title', '關於我們 | 楷懿國際投資')
@section('twitter_description', '認識楷懿國際投資的企業理念、公司沿革與專業團隊，以「專業・責任・價值」服務跨國不動產投資客戶。')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}?v=20260610">
@endpush

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-bg"
            style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1920&q=80');">
        </div>
        <div class="page-header-overlay"></div>
        <div class="page-header-content">
            <h1>{{ cb('about', 'header.title') }}</h1>
            <p>{{ cb('about', 'header.subtitle') }}</p>
        </div>
    </section>

    <!-- Company Philosophy -->
    <section class="section philosophy-section">
        <div class="container">
            <div class="content-grid">
                <div class="content-image">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80" alt="企業理念">
                </div>
                <div class="content-text">
                    <p class="section-subtitle">{{ cb('about', 'philosophy.section_subtitle') }}</p>
                    <h2>{{ cb('about', 'philosophy.section_title') }}</h2>
                    <p>{!! cb('about', 'philosophy.intro') !!}</p>
                    <ul class="philosophy-list">
                        <li>
                            <span class="philosophy-key">{{ cb('about', 'philosophy.item1_key') }}</span>
                            <span class="philosophy-arrow">→</span>
                            <span class="philosophy-val">{{ cb('about', 'philosophy.item1_val') }}</span>
                        </li>
                        <li>
                            <span class="philosophy-key">{{ cb('about', 'philosophy.item2_key') }}</span>
                            <span class="philosophy-arrow">→</span>
                            <span class="philosophy-val">{{ cb('about', 'philosophy.item2_val') }}</span>
                        </li>
                        <li>
                            <span class="philosophy-key">{{ cb('about', 'philosophy.item3_key') }}</span>
                            <span class="philosophy-arrow">→</span>
                            <span class="philosophy-val">{{ cb('about', 'philosophy.item3_val') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="core-values">
                <div class="value-box">
                    <div class="value-name">{{ cb('about', 'value1.title') }}</div>
                </div>
                <div class="value-box">
                    <div class="value-name">{{ cb('about', 'value2.title') }}</div>
                </div>
                <div class="value-box">
                    <div class="value-name">{{ cb('about', 'value3.title') }}</div>
                </div>
                <div class="value-box">
                    <div class="value-name">{{ cb('about', 'value4.title') }}</div>
                </div>
                <div class="value-box">
                    <div class="value-name">{{ cb('about', 'value5.title') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company History Timeline -->
    <section class="section timeline-section">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('about', 'timeline.section_subtitle') }}</p>
                <h2 class="section-title">{{ cb('about', 'timeline.section_title') }}</h2>
            </div>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">{{ cb('about', 'timeline1.year') }}</div>
                        <h3>{{ cb('about', 'timeline1.title') }}</h3>
                        <p>{{ cb('about', 'timeline1.desc') }}</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">{{ cb('about', 'timeline2.year') }}</div>
                        <h3>{{ cb('about', 'timeline2.title') }}</h3>
                        <p>{{ cb('about', 'timeline2.desc') }}</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">{{ cb('about', 'timeline3.year') }}</div>
                        <h3>{{ cb('about', 'timeline3.title') }}</h3>
                        <p>{{ cb('about', 'timeline3.desc') }}</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">{{ cb('about', 'timeline4.year') }}</div>
                        <h3>{{ cb('about', 'timeline4.title') }}</h3>
                        <p>{{ cb('about', 'timeline4.desc') }}</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-year">{{ cb('about', 'timeline5.year') }}</div>
                        <h3>{{ cb('about', 'timeline5.title') }}</h3>
                        <p>{{ cb('about', 'timeline5.desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

