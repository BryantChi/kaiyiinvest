{{-- 前台主導覽列。連結用 localized_route 保留目前語系前綴；active 同時比對語系版名稱 --}}
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ localized_route('frontend.home') }}" class="logo">
            <img src="{{ asset('assets/img/logo/logo.png') }}" class="img-fluid" alt="楷懿國際投資">
            <div class="logo-text">
                <span class="logo-main">KAIYI</span>
                <span class="logo-sub">楷懿國際投資</span>
            </div>
        </a>
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ localized_route('frontend.home') }}" class="nav-link {{ request()->routeIs('frontend.home', 'frontend.*.home') ? 'active' : '' }}">首頁</a></li>
            <li><a href="{{ localized_route('frontend.about') }}" class="nav-link {{ request()->routeIs('frontend.about', 'frontend.*.about') ? 'active' : '' }}">關於我們</a></li>
            <li>
                <a href="{{ localized_route('frontend.services') }}" class="nav-link {{ request()->routeIs('frontend.services', 'frontend.*.services') ? 'active' : '' }}">
                    服務項目
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="{{ localized_route('frontend.services') }}#real-estate" class="dropdown-item">
                        <i class="fas fa-building"></i>不動產代理項目
                    </a>
                    <a href="{{ localized_route('frontend.services') }}#industrial" class="dropdown-item">
                        <i class="fas fa-industry"></i>工業地產
                    </a>
                    <a href="{{ localized_route('frontend.services') }}#consulting" class="dropdown-item">
                        <i class="fas fa-users-cog"></i>專業諮詢
                    </a>
                    <a href="{{ localized_route('frontend.services') }}#other" class="dropdown-item">
                        <i class="fas fa-tools"></i>其他服務
                    </a>
                </div>
            </li>
            <li><a href="{{ localized_route('frontend.partners') }}" class="nav-link {{ request()->routeIs('frontend.partners', 'frontend.*.partners') ? 'active' : '' }}">關係企業</a></li>
            <li><a href="{{ localized_route('frontend.contact') }}" class="nav-link {{ request()->routeIs('frontend.contact', 'frontend.*.contact') ? 'active' : '' }}">聯絡我們</a></li>
            @include('frontend.partials.lang-switcher')
        </ul>
        <div class="mobile-toggle" id="mobileToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>
