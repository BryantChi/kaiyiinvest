@extends('frontend.layouts.app')

@section('title', '工業區開發招商 | 楷懿國際投資')

@section('meta_description', '楷懿國際投資的工業區開發招商服務，從選址、開發到招商的專業流程，協助企業布局越南工業地產。')

@section('meta_keywords', '工業區開發,招商,工業地產,越南工業區,廠房開發,楷懿國際投資')

@section('canonical', 'https://kaiyiinvest.com/industrial-development.html')

@section('og_title', '工業區開發招商 | 楷懿國際投資')

@section('og_description', '楷懿國際投資的工業區開發招商服務，從選址、開發到招商的專業流程，協助企業布局越南工業地產。')

@section('twitter_title', '工業區開發招商 | 楷懿國際投資')

@section('twitter_description', '楷懿國際投資的工業區開發招商服務，從選址、開發到招商的專業流程，協助企業布局越南工業地產。')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/services.css') }}?v=20260605">
    <link rel="stylesheet" href="{{ asset('assets/css/industrial-development.css') }}?v=20260605">
@endpush

@section('content')
    <section class="page-header">
        <div class="page-header-bg"
            style="background-image: url('https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1920&q=80');">
        </div>
        <div class="page-header-overlay"></div>
        <div class="page-header-content">
            <h1>{{ cb('industrial-development', 'header.title') }}</h1>
            <p>{{ cb('industrial-development', 'header.subtitle') }}</p>
            <div class="breadcrumb">
                <a href="{{ route('frontend.home') }}">首頁</a>
                <span>/</span>
                <a href="{{ route('frontend.services') }}">服務項目</a>
                <span>/</span>
                <span>工業區開發招商</span>
            </div>
        </div>
    </section>

    <!-- Service Overview Section -->
    <section class="section service-overview">
        <div class="container">
            <div class="overview-grid">
                <div class="overview-content">
                    <div class="section-header">
                        <p class="section-subtitle">{{ cb('industrial-development', 'overview.subtitle') }}</p>
                        <h2 class="section-title">{{ cb('industrial-development', 'overview.title') }}</h2>
                    </div>
                    <div class="overview-text">
                        <p class="lead">{{ cb('industrial-development', 'overview.lead') }}</p>
                        <p>{!! cb('industrial-development', 'overview.intro') !!}
                        </p>
                        <ul class="achievement-list">
                            <li>
                                <i class="fas fa-check-circle"></i>
                                <span>十餘年與政府機關合作經驗</span>
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                <span>協助完成多個具指標性園區開發專案</span>
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                <span>數百公頃產業用地成功開發</span>
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                <span>媒合數百家產業龍頭與製造業廠商</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="overview-image">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80" alt="工業區開發">
                    <div class="image-badge">
                        <i class="fas fa-industry"></i>
                        <span>專業開發</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Process Section -->
    <section class="section service-process">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('industrial-development', 'process.subtitle') }}</p>
                <h2 class="section-title">{{ cb('industrial-development', 'process.title') }}</h2>
                <p class="section-description">{!! cb('industrial-development', 'process.description') !!}</p>
            </div>

            <!-- Top Row: 4 Icons -->
            <div class="process-icons-row">
                <div class="process-icon-item">
                    <div class="icon-circle">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="icon-label">土地</div>
                </div>
                <div class="process-icon-item">
                    <div class="icon-circle">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="icon-label">規劃</div>
                </div>
                <div class="process-icon-item">
                    <div class="icon-circle">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="icon-label">執行興建</div>
                </div>
                <div class="process-icon-item">
                    <div class="icon-circle">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="icon-label">出(租)(售)</div>
                </div>
            </div>

            <!-- Arrow Flow Diagram -->
            <div class="process-flow">
                <div class="flow-arrow flow-arrow-blue">
                    <div class="arrow-content">土地</div>
                </div>
                <div class="flow-arrow flow-arrow-gold">
                    <div class="arrow-content">工程設計</div>
                </div>
                <div class="flow-arrow flow-arrow-blue">
                    <div class="arrow-content">興建</div>
                </div>
                <div class="flow-arrow flow-arrow-gold">
                    <div class="arrow-content">招商</div>
                </div>
            </div>

            <!-- Bottom Description -->
            <div class="process-description">
                <div class="description-arrow description-arrow-left">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </div>
                <div class="description-text">
                    整體行銷規劃、活動企劃執行
                </div>
                <div class="description-arrow description-arrow-right">
                    <i class="fas fa-long-arrow-alt-right"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Features Section -->
    <section class="section service-features">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('industrial-development', 'features.subtitle') }}</p>
                <h2 class="section-title">{{ cb('industrial-development', 'features.title') }}</h2>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'feature1.title') }}</h3>
                    <p>{{ cb('industrial-development', 'feature1.desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'feature2.title') }}</h3>
                    <p>{{ cb('industrial-development', 'feature2.desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'feature3.title') }}</h3>
                    <p>{{ cb('industrial-development', 'feature3.desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'feature4.title') }}</h3>
                    <p>{{ cb('industrial-development', 'feature4.desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'feature5.title') }}</h3>
                    <p>{{ cb('industrial-development', 'feature5.desc') }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'feature6.title') }}</h3>
                    <p>{{ cb('industrial-development', 'feature6.desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Scope Section -->
    <section class="section service-scope">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('industrial-development', 'scope.subtitle') }}</p>
                <h2 class="section-title">{{ cb('industrial-development', 'scope.title') }}</h2>
            </div>

            <div class="scope-accordion">
                <div class="scope-item">
                    <div class="scope-header">
                        <div class="scope-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h3>{{ cb('industrial-development', 'scope1.title') }}</h3>
                        <i class="fas fa-chevron-down accordion-toggle"></i>
                    </div>
                    <div class="scope-content">
                        <ul>
                            <li><i class="fas fa-check"></i>土地取得策略規劃</li>
                            <li><i class="fas fa-check"></i>土地使用分區規劃</li>
                            <li><i class="fas fa-check"></i>基礎設施配置規劃</li>
                            <li><i class="fas fa-check"></i>環境影響評估</li>
                            <li><i class="fas fa-check"></i>都市計畫變更申請</li>
                        </ul>
                    </div>
                </div>

                <div class="scope-item">
                    <div class="scope-header">
                        <div class="scope-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h3>{{ cb('industrial-development', 'scope2.title') }}</h3>
                        <i class="fas fa-chevron-down accordion-toggle"></i>
                    </div>
                    <div class="scope-content">
                        <ul>
                            <li><i class="fas fa-check"></i>開發許可申請</li>
                            <li><i class="fas fa-check"></i>建築執照申請</li>
                            <li><i class="fas fa-check"></i>環評審查協調</li>
                            <li><i class="fas fa-check"></i>地目變更申請</li>
                            <li><i class="fas fa-check"></i>相關法規諮詢</li>
                        </ul>
                    </div>
                </div>

                <div class="scope-item">
                    <div class="scope-header">
                        <div class="scope-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3>{{ cb('industrial-development', 'scope3.title') }}</h3>
                        <i class="fas fa-chevron-down accordion-toggle"></i>
                    </div>
                    <div class="scope-content">
                        <ul>
                            <li><i class="fas fa-check"></i>工程規劃設計</li>
                            <li><i class="fas fa-check"></i>施工品質監督</li>
                            <li><i class="fas fa-check"></i>進度管理控制</li>
                            <li><i class="fas fa-check"></i>成本控管分析</li>
                            <li><i class="fas fa-check"></i>驗收交付管理</li>
                        </ul>
                    </div>
                </div>

                <div class="scope-item">
                    <div class="scope-header">
                        <div class="scope-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3>{{ cb('industrial-development', 'scope4.title') }}</h3>
                        <i class="fas fa-chevron-down accordion-toggle"></i>
                    </div>
                    <div class="scope-content">
                        <ul>
                            <li><i class="fas fa-check"></i>目標產業分析</li>
                            <li><i class="fas fa-check"></i>招商策略擬定</li>
                            <li><i class="fas fa-check"></i>行銷活動執行</li>
                            <li><i class="fas fa-check"></i>企業洽談媒合</li>
                            <li><i class="fas fa-check"></i>投資優惠規劃</li>
                        </ul>
                    </div>
                </div>

                <div class="scope-item">
                    <div class="scope-header">
                        <div class="scope-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>{{ cb('industrial-development', 'scope5.title') }}</h3>
                        <i class="fas fa-chevron-down accordion-toggle"></i>
                    </div>
                    <div class="scope-content">
                        <ul>
                            <li><i class="fas fa-check"></i>園區管理規劃</li>
                            <li><i class="fas fa-check"></i>物業服務管理</li>
                            <li><i class="fas fa-check"></i>設施維護管理</li>
                            <li><i class="fas fa-check"></i>廠商服務協調</li>
                            <li><i class="fas fa-check"></i>產業升級輔導</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Target Industries Section -->
    <section class="section target-industries">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">{{ cb('industrial-development', 'industries.subtitle') }}</p>
                <h2 class="section-title">{{ cb('industrial-development', 'industries.title') }}</h2>
            </div>

            <div class="industries-grid">
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'industry1.title') }}</h3>
                    <p>{{ cb('industrial-development', 'industry1.desc') }}</p>
                </div>

                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'industry2.title') }}</h3>
                    <p>{{ cb('industrial-development', 'industry2.desc') }}</p>
                </div>

                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'industry3.title') }}</h3>
                    <p>{{ cb('industrial-development', 'industry3.desc') }}</p>
                </div>

                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'industry4.title') }}</h3>
                    <p>{{ cb('industrial-development', 'industry4.desc') }}</p>
                </div>

                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-solar-panel"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'industry5.title') }}</h3>
                    <p>{{ cb('industrial-development', 'industry5.desc') }}</p>
                </div>

                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <h3>{{ cb('industrial-development', 'industry6.title') }}</h3>
                    <p>{{ cb('industrial-development', 'industry6.desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>{{ cb('industrial-development', 'cta.title') }}</h2>
                <p>{{ cb('industrial-development', 'cta.description') }}</p>
                <div class="cta-buttons">
                    <a href="{{ route('frontend.contact') }}" class="btn btn-primary">
                        <i class="fas fa-phone"></i>
                        {{ cb('industrial-development', 'cta.button_primary') }}
                    </a>
                    <a href="{{ route('frontend.services') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        {{ cb('industrial-development', 'cta.button_secondary') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('page-js')
    <script src="{{ asset('assets/js/industrial-development.js') }}?v=20260605"></script>
@endpush

