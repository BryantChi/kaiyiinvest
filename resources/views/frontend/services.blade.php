@extends('frontend.layouts.app')

@section('title', '服務項目 | 楷懿國際投資')
@section('meta_description', '楷懿四大業務領域 — 不動產代理、工業地產、專業諮詢與其他服務，提供完整的越南不動產投資解決方案。')
@section('meta_keywords', '楷懿服務項目,不動產代理,工業地產,專業諮詢,越南不動產投資')
@section('canonical', 'https://kaiyiinvest.com/services.html')

@section('og_title', '服務項目 | 楷懿國際投資')
@section('og_description', '楷懿四大業務領域 — 不動產代理、工業地產、專業諮詢與其他服務，提供完整的越南不動產投資解決方案。')

@section('twitter_title', '服務項目 | 楷懿國際投資')
@section('twitter_description', '楷懿四大業務領域 — 不動產代理、工業地產、專業諮詢與其他服務，提供完整的越南不動產投資解決方案。')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/services.css') }}?v=20260605">
@endpush

@section('content')
    <section class="page-header">
        <div class="page-header-bg"
            style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1920&q=80');">
        </div>
        <div class="page-header-overlay"></div>
        <div class="page-header-content">
            <h1>{{ cb('services','header.title') }}</h1>
            <p>{{ cb('services','header.subtitle') }}</p>
        </div>
    </section>

    <section class="section services-section">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('services','process.section_subtitle') }}</p>
                <h2 class="section-title">{{ cb('services','process.section_title') }}</h2>
                <p class="section-description">{!! cb('services','process.section_description') !!}</p>
            </div>

            <div class="process-timeline">
                <div class="process-step" data-step="1">
                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-number">01</div>
                            <div class="step-icon">
                                <i class="fas fa-search-location"></i>
                            </div>
                        </div>
                        <div class="step-content">
                            <h3>{{ cb('services','step1.eyebrow') }}</h3>
                            <h4>{{ cb('services','step1.title') }}</h4>
                            <p>{{ cb('services','step1.desc') }}</p>
                        </div>
                    </div>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 50" class="connector-line">
                            <path d="M 0 25 Q 50 25 100 25" stroke="currentColor" fill="none" stroke-width="2" />
                            <circle cx="100" cy="25" r="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <div class="process-step" data-step="2">
                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-number">02</div>
                            <div class="step-icon">
                                <i class="fas fa-drafting-compass"></i>
                            </div>
                        </div>
                        <div class="step-content">
                            <h3>{{ cb('services','step2.eyebrow') }}</h3>
                            <h4>{{ cb('services','step2.title') }}</h4>
                            <p>{{ cb('services','step2.desc') }}</p>
                        </div>
                    </div>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 50" class="connector-line">
                            <path d="M 0 25 Q 50 25 100 25" stroke="currentColor" fill="none" stroke-width="2" />
                            <circle cx="100" cy="25" r="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <div class="process-step" data-step="3">
                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-number">03</div>
                            <div class="step-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                        <div class="step-content">
                            <h3>{{ cb('services','step3.eyebrow') }}</h3>
                            <h4>{{ cb('services','step3.title') }}</h4>
                            <p>{{ cb('services','step3.desc') }}</p>
                        </div>
                    </div>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 50" class="connector-line">
                            <path d="M 0 25 Q 50 25 100 25" stroke="currentColor" fill="none" stroke-width="2" />
                            <circle cx="100" cy="25" r="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <div class="process-step" data-step="4">
                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-number">04</div>
                            <div class="step-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                        </div>
                        <div class="step-content">
                            <h3>{{ cb('services','step4.eyebrow') }}</h3>
                            <h4>{{ cb('services','step4.title') }}</h4>
                            <p>{{ cb('services','step4.desc') }}</p>
                        </div>
                    </div>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 50" class="connector-line">
                            <path d="M 0 25 Q 50 25 100 25" stroke="currentColor" fill="none" stroke-width="2" />
                            <circle cx="100" cy="25" r="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <div class="process-step" data-step="5">
                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-number">05</div>
                            <div class="step-icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="step-content">
                            <h3>{{ cb('services','step5.eyebrow') }}</h3>
                            <h4>{{ cb('services','step5.title') }}</h4>
                            <p>{{ cb('services','step5.desc') }}</p>
                        </div>
                    </div>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 50" class="connector-line">
                            <path d="M 0 25 Q 50 25 100 25" stroke="currentColor" fill="none" stroke-width="2" />
                            <circle cx="100" cy="25" r="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>

                <div class="process-step" data-step="6">
                    <div class="step-wrapper">
                        <div class="step-icon-wrapper">
                            <div class="step-number">06</div>
                            <div class="step-icon">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                        </div>
                        <div class="step-content">
                            <h3>{{ cb('services','step6.eyebrow') }}</h3>
                            <h4>{{ cb('services','step6.title') }}</h4>
                            <p>{{ cb('services','step6.desc') }}</p>
                        </div>
                    </div>
                    <div class="step-connector">
                        <svg viewBox="0 0 100 50" class="connector-line">
                            <path d="M 0 25 Q 50 25 100 25" stroke="currentColor" fill="none" stroke-width="2" />
                            <circle cx="100" cy="25" r="4" fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section sub-services-section">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('services','domains.section_subtitle') }}</p>
                <h2 class="section-title">{{ cb('services','domains.section_title') }}</h2>
            </div>
            <div class="sub-services-grid">
                <div class="sub-service-card" id="real-estate">
                    <div class="sub-service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3><a href="{{ route('frontend.rental-management') }}">{{ cb('services','realestate.title') }}</a></h3>
                    <ul class="sub-service-list">
                        <li>{{ cb('services','realestate.item1') }}</li>
                        <li><a href="{{ route('frontend.rental-management') }}">{{ cb('services','realestate.item2') }}</a></li>
                        <li>{{ cb('services','realestate.item3') }}</li>
                    </ul>
                </div>
                <div class="sub-service-card" id="industrial">
                    <div class="sub-service-icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h3><a href="{{ route('frontend.industrial-development') }}">{{ cb('services','industrial.title') }}</a></h3>
                    <ul class="sub-service-list">
                        <li><a href="{{ route('frontend.industrial-development') }}">{{ cb('services','industrial.item1') }}</a></li>
                        <li>{{ cb('services','industrial.item2') }}</li>
                        <li>{{ cb('services','industrial.item3') }}</li>
                        <li>{{ cb('services','industrial.item4') }}</li>
                    </ul>
                </div>
                <div class="sub-service-card" id="consulting">
                    <div class="sub-service-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3>{{ cb('services','consulting.title') }}</h3>
                    <ul class="sub-service-list">
                        <li>{{ cb('services','consulting.item1') }}</li>
                        <li>{{ cb('services','consulting.item2') }}</li>
                        <li>{{ cb('services','consulting.item3') }}</li>
                    </ul>
                </div>
                <div class="sub-service-card" id="other">
                    <div class="sub-service-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>{{ cb('services','other.title') }}</h3>
                    <ul class="sub-service-list">
                        <li>{{ cb('services','other.item1') }}</li>
                        <li>{{ cb('services','other.item2') }}</li>
                        <li>{{ cb('services','other.item3') }}</li>
                        <li>{{ cb('services','other.item4') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

