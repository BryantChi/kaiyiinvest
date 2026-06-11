{{-- 前台主導覽列。連結用 localized_route 保留目前語系前綴；active 同時比對語系版名稱 --}}
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ localized_route('frontend.home') }}" class="logo">
            <img src="{{ asset('assets/img/logo/logo.png') }}" class="img-fluid" alt="{{ cb('global', 'company.name') }}">
            <div class="logo-text">
                <span class="logo-main">KAIYI</span>
                <span class="logo-sub">{{ cb('global', 'company.name') }}</span>
            </div>
        </a>
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ localized_route('frontend.home') }}" class="nav-link {{ request()->routeIs('frontend.home', 'frontend.*.home') ? 'active' : '' }}">{{ cb('global', 'nav.home') }}</a></li>
            <li><a href="{{ localized_route('frontend.about') }}" class="nav-link {{ request()->routeIs('frontend.about', 'frontend.*.about') ? 'active' : '' }}">{{ cb('global', 'nav.about') }}</a></li>
            <li>
                <a href="{{ localized_route('frontend.services') }}" class="nav-link {{ request()->routeIs('frontend.services', 'frontend.*.services') ? 'active' : '' }}">
                    {{ cb('global', 'nav.services') }}
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="{{ localized_route('frontend.services') }}#real-estate" class="dropdown-item">
                        <i class="fas fa-building"></i>{{ cb('global', 'nav.svc_real_estate') }}
                    </a>
                    <a href="{{ localized_route('frontend.services') }}#industrial" class="dropdown-item">
                        <i class="fas fa-industry"></i>{{ cb('global', 'nav.svc_industrial') }}
                    </a>
                    <a href="{{ localized_route('frontend.services') }}#consulting" class="dropdown-item">
                        <i class="fas fa-users-cog"></i>{{ cb('global', 'nav.svc_consulting') }}
                    </a>
                    <a href="{{ localized_route('frontend.services') }}#other" class="dropdown-item">
                        <i class="fas fa-tools"></i>{{ cb('global', 'nav.svc_other') }}
                    </a>
                </div>
            </li>
            <li><a href="{{ localized_route('frontend.partners') }}" class="nav-link {{ request()->routeIs('frontend.partners', 'frontend.*.partners') ? 'active' : '' }}">{{ cb('global', 'nav.partners') }}</a></li>
            <li><a href="{{ localized_route('frontend.contact') }}" class="nav-link {{ request()->routeIs('frontend.contact', 'frontend.*.contact') ? 'active' : '' }}">{{ cb('global', 'nav.contact') }}</a></li>
            @include('frontend.partials.lang-switcher')
        </ul>
        <div class="mobile-toggle" id="mobileToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>
