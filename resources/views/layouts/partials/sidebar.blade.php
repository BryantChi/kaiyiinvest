{{-- Logo 品牌區 --}}
<div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-full">
        <div class="brand-logo">
            <svg class="brand-icon">
                <use xlink:href="/assets/icons/free.svg#cil-layers"></use>
            </svg>
        </div>
        <div class="brand-text">
            <span class="brand-name">{{ config('app.name') }}</span>
            <span class="brand-subtitle">Admin Panel</span>
        </div>
    </a>
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-narrow">
        <svg class="brand-icon-narrow">
            <use xlink:href="/assets/icons/free.svg#cil-layers"></use>
        </svg>
    </a>
</div>

<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    {{-- 儀表板 --}}
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.dashboard') }}" href="{{ route('admin.dashboard') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-speedometer"></use>
            </svg>
            儀表板
        </a>
    </li>

    {{-- 內容管理 --}}
    <li class="nav-title">內容管理</li>

    @can('view articles')
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.articles') }}" href="{{ route('admin.articles.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-newspaper"></use>
            </svg>
            文章管理
            @php
                $draftCount = \App\Models\Article::where('status', 'draft')->count();
            @endphp
            @if($draftCount > 0)
            <span class="badge badge-sm bg-warning text-dark ms-auto">{{ $draftCount }}</span>
            @endif
        </a>
    </li>
    @endcan

    @can('view categories')
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.categories') }}" href="{{ route('admin.categories.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-folder"></use>
            </svg>
            分類管理
        </a>
    </li>
    @endcan

    @can('view tags')
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.tags') }}" href="{{ route('admin.tags.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-tags"></use>
            </svg>
            標籤管理
        </a>
    </li>
    @endcan

    {{-- 前台網站 --}}
    <li class="nav-title">前台網站</li>

    @can('manage content')
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.content') }}" href="{{ route('admin.content.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-pencil"></use>
            </svg>
            頁面內容
        </a>
    </li>
    @endcan

    @can('view faqs')
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.faqs') }}" href="{{ route('admin.faqs.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-list"></use>
            </svg>
            FAQ 管理
        </a>
    </li>
    @endcan

    @can('view contacts')
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.contacts') }}" href="{{ route('admin.contacts.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-envelope-closed"></use>
            </svg>
            聯絡訊息
            @php
                $unreadContacts = \App\Models\Contact::where('is_read', false)->count();
            @endphp
            @if($unreadContacts > 0)
            <span class="badge badge-sm bg-warning text-dark ms-auto">{{ $unreadContacts }}</span>
            @endif
        </a>
    </li>
    @endcan

    @can('manage locales')
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.locales') }}" href="{{ route('admin.locales.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-language"></use>
            </svg>
            語系管理
        </a>
    </li>
    @endcan

    {{-- 用戶管理 --}}
    @can('view users')
    <li class="nav-title">用戶管理</li>

    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.users') }}" href="{{ route('admin.users.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-people"></use>
            </svg>
            用戶管理
        </a>
    </li>
    @endcan

    {{-- SEO 與分析 --}}
    @can('view seo')
    <li class="nav-title">SEO 與分析</li>

    <li class="nav-group {{ active_route(['admin.seo']) }}">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-chart-line"></use>
            </svg>
            SEO 管理
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.seo.index') }}" href="{{ route('admin.seo.index') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    總覽
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.seo.pages') }}" href="{{ route('admin.seo.pages') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    頁面 SEO
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.seo.meta') }}" href="{{ route('admin.seo.meta') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    Meta 管理
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.seo.sitemap-settings') }}" href="{{ route('admin.seo.sitemap-settings') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    Sitemap 設定
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.seo.robots-txt') }}" href="{{ route('admin.seo.robots-txt') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    Robots.txt
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.seo.analyze') }}" href="{{ route('admin.seo.analyze') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    SEO 分析
                    @php
                        $articlesWithoutSeo = \App\Models\Article::doesntHave('seoMeta')->count();
                    @endphp
                    @if($articlesWithoutSeo > 0)
                    <span class="badge badge-sm bg-warning text-dark ms-auto">{{ $articlesWithoutSeo }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </li>
    @endcan

    {{-- 系統設定 --}}
    @can('view settings')
    <li class="nav-title">系統設定</li>

    <li class="nav-group {{ active_route(['admin.settings']) }}">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-settings"></use>
            </svg>
            系統設定
        </a>
        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.settings.general') }}" href="{{ route('admin.settings.general') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    一般設定
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.settings.seo') }}" href="{{ route('admin.settings.seo') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    SEO 設定
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.settings.analytics') }}" href="{{ route('admin.settings.analytics') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    分析設定
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_route('admin.settings.mail') }}" href="{{ route('admin.settings.mail') }}">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    郵件設定
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.system-info') }}" href="{{ route('admin.system-info') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-info"></use>
            </svg>
            系統資訊
        </a>
    </li>
    @endcan

    {{-- 工程師專屬 --}}
    @if(auth()->user()->isEngineer())
    <li class="nav-title">工程師</li>
    <li class="nav-item">
        <a class="nav-link {{ active_route('admin.engineer') }}" href="{{ route('admin.engineer.index') }}">
            <svg class="nav-icon">
                <use xlink:href="/assets/icons/free.svg#cil-terminal"></use>
            </svg>
            工程師工具
        </a>
    </li>
    @endif
</ul>

<div class="sidebar-footer">
    <button class="sidebar-toggler" type="button"></button>
</div>
