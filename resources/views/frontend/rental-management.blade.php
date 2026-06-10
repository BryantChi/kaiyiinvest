@extends('frontend.layouts.app')

@section('title', '包租代管 | 楷懿國際投資')

@section('meta_description', '楷懿專業包租代管服務，提供越南不動產的租賃管理、收益優化與一站式託管。')
@section('meta_keywords', '包租代管,租賃管理,物業託管,越南不動產出租,收益優化,楷懿國際投資')

@section('canonical', 'https://kaiyiinvest.com/rental-management.html')

@section('og_title', '包租代管 | 楷懿國際投資')
@section('og_description', '楷懿專業包租代管服務，提供越南不動產的租賃管理、收益優化與一站式託管。')

@section('twitter_title', '包租代管 | 楷懿國際投資')
@section('twitter_description', '楷懿專業包租代管服務，提供越南不動產的租賃管理、收益優化與一站式託管。')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/services.css') }}?v=20260610">
    <link rel="stylesheet" href="{{ asset('assets/css/rental-management.css') }}?v=20260610">
@endpush

@section('content')
    <section class="page-header">
        <div class="page-header-bg"
            style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1920&q=80');">
        </div>
        <div class="page-header-overlay"></div>
        <div class="page-header-content">
            <h1>{{ cb('rental-management','header.title') }}</h1>
            <p>{{ cb('rental-management','header.subtitle') }}</p>
            <div class="breadcrumb">
                <a href="{{ route('frontend.home') }}">首頁</a>
                <span>/</span>
                <a href="{{ route('frontend.services') }}">服務項目</a>
                <span>/</span>
                <span>包租代管</span>
            </div>
        </div>
    </section>

    <section class="section service-intro">
        <div class="container">
            <div class="intro-content">
                <div class="section-header">
                    <p class="section-subtitle">{{ cb('rental-management','intro.subtitle') }}</p>
                    <h2 class="section-title">{{ cb('rental-management','intro.title') }}</h2>
                </div>
                <p class="intro-text">
                    {!! cb('rental-management','intro.body') !!}
                </p>
            </div>
        </div>
    </section>

    <section class="section our-services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ cb('rental-management','services.title') }}</h2>
            </div>

            <div class="services-grid">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3>{{ cb('rental-management','service1.title') }}</h3>
                    <p>{{ cb('rental-management','service1.body') }}</p>
                </div>

                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <h3>{{ cb('rental-management','service2.title') }}</h3>
                    <p>{{ cb('rental-management','service2.body') }}</p>
                </div>

                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3>{{ cb('rental-management','service3.title') }}</h3>
                    <p>{{ cb('rental-management','service3.body') }}</p>
                </div>

                <div class="service-item">
                    <div class="service-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>{{ cb('rental-management','service4.title') }}</h3>
                    <p>{{ cb('rental-management','service4.body') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section workflow-section">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('rental-management','workflow.subtitle') }}</p>
                <h2 class="section-title">{{ cb('rental-management','workflow.title') }}</h2>
            </div>

            <div class="workflow-steps">
                <div class="workflow-step">
                    <div class="step-circle">
                        <div class="step-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                    <div class="step-number">STEP.01</div>
                    <h3>{{ cb('rental-management','workflow.step1_title') }}</h3>
                    <p>{{ cb('rental-management','workflow.step1_body') }}</p>
                </div>

                <div class="workflow-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>

                <div class="workflow-step">
                    <div class="step-circle">
                        <div class="step-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="step-number">STEP.02</div>
                    <h3>{{ cb('rental-management','workflow.step2_title') }}</h3>
                    <p>{{ cb('rental-management','workflow.step2_body') }}</p>
                </div>

                <div class="workflow-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>

                <div class="workflow-step">
                    <div class="step-circle">
                        <div class="step-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="step-number">STEP.03</div>
                    <h3>{{ cb('rental-management','workflow.step3_title') }}</h3>
                    <p>{{ cb('rental-management','workflow.step3_body') }}</p>
                </div>

                <div class="workflow-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>

                <div class="workflow-step">
                    <div class="step-circle">
                        <div class="step-icon">
                            <i class="fas fa-file-signature"></i>
                        </div>
                    </div>
                    <div class="step-number">STEP.04</div>
                    <h3>{{ cb('rental-management','workflow.step4_title') }}</h3>
                    <p>{{ cb('rental-management','workflow.step4_body') }}</p>
                </div>

                <div class="workflow-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>

                <div class="workflow-step">
                    <div class="step-circle">
                        <div class="step-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                    <div class="step-number">STEP.05</div>
                    <h3>{{ cb('rental-management','workflow.step5_title') }}</h3>
                    <p>{{ cb('rental-management','workflow.step5_body') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section benefits-section">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('rental-management','benefits.subtitle') }}</p>
                <h2 class="section-title">{{ cb('rental-management','benefits.title') }}</h2>
            </div>

            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>{{ cb('rental-management','benefit1.title') }}</h3>
                    <p>{{ cb('rental-management','benefit1.body') }}</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>{{ cb('rental-management','benefit2.title') }}</h3>
                    <p>{{ cb('rental-management','benefit2.body') }}</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3>{{ cb('rental-management','benefit3.title') }}</h3>
                    <p>{{ cb('rental-management','benefit3.body') }}</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>{{ cb('rental-management','benefit4.title') }}</h3>
                    <p>{{ cb('rental-management','benefit4.body') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>{{ cb('rental-management','cta.title') }}</h2>
                <p>{{ cb('rental-management','cta.subtitle') }}</p>
                <div class="cta-buttons">
                    <a href="{{ route('frontend.contact') }}" class="btn btn-primary">
                        <i class="fas fa-phone"></i>
                        {{ cb('rental-management','cta.button_primary') }}
                    </a>
                    <a href="{{ route('frontend.services') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        {{ cb('rental-management','cta.button_secondary') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

