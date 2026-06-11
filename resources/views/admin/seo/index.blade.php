@extends('layouts.admin')

@section('title', 'SEO 管理')

@php $breadcrumbs = [['title' => 'SEO 管理', 'url' => '#']]; @endphp

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">SEO 管理</h2>
        <p class="text-muted">搜尋引擎優化（SEO）+ 生成式引擎（GEO）+ 答案引擎（AEO）</p>
    </div>
</div>

{{-- 統計卡 --}}
<div class="row">
    @php
        $cards = [
            ['頁面數', $stats['pages'], 'cil-globe-alt', 'primary', route('admin.seo.pages'), '頁面 SEO'],
            ['Sitemap URL', $stats['sitemap_urls'], 'cil-sitemap', 'success', route('admin.seo.sitemap'), 'Sitemap'],
            ['SEO 涵蓋率', $stats['coverage'] . '%', 'cil-check-circle', 'info', route('admin.seo.pages'), '前往補齊'],
            ['FAQ（AEO）', $stats['faqs'], 'cil-list-rich', 'warning', route('admin.faqs.index'), 'FAQ 管理'],
        ];
    @endphp
    @foreach($cards as [$label, $value, $icon, $color, $url, $link])
    <div class="col-lg-3 col-md-6">
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="bg-{{ $color }} bg-opacity-10 p-3 rounded">
                    <svg class="icon icon-xl text-{{ $color }}"><use xlink:href="/assets/icons/free.svg#{{ $icon }}"></use></svg>
                </div>
                <div class="ms-3">
                    <div class="fs-5 fw-semibold">{{ $value }}</div>
                    <div class="text-muted small">{{ $label }}</div>
                </div>
            </div>
            <div class="card-footer border-top-0 bg-transparent">
                <a href="{{ $url }}" class="text-decoration-none small">{{ $link }} →</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header"><strong>SEO 工具</strong></div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @php
                        $tools = [
                            [route('admin.seo.settings'), '網站 SEO 設定', 'GA4 / GTM / Search Console 驗證 / 預設 Meta 與 OG 圖', 'cil-settings'],
                            [route('admin.seo.pages'), '頁面 SEO（每頁每語系）', 'Meta / OG / Twitter / JSON-LD 結構化資料', 'cil-globe-alt'],
                            [route('admin.seo.sitemap'), 'Sitemap', '多語 sitemap.xml + 通知搜尋引擎', 'cil-sitemap'],
                            [route('admin.seo.robots-txt'), 'robots.txt', '爬蟲規則', 'cil-shield-alt'],
                            [route('admin.seo.llms-txt'), 'llms.txt（AEO）', '提供 AI / 答案引擎的站點摘要', 'cil-brain'],
                            [route('admin.seo.analyze'), 'SEO 分析', '檢查缺漏與優化建議', 'cil-chart-line'],
                        ];
                    @endphp
                    @foreach($tools as [$url, $title, $desc, $icon])
                    <a href="{{ $url }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <svg class="icon me-2 text-primary"><use xlink:href="/assets/icons/free.svg#{{ $icon }}"></use></svg>
                            <strong>{{ $title }}</strong>
                            <div class="small text-muted ms-4 ps-2">{{ $desc }}</div>
                        </div>
                        <svg class="icon"><use xlink:href="/assets/icons/free.svg#cil-chevron-right"></use></svg>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header"><strong>站台健檢</strong></div>
            <div class="card-body">
                @php
                    $checks = [
                        ['GA4 / GTM 分析', $status['ga4'] || $status['gtm']],
                        ['Google Search Console 驗證', $status['google_verify']],
                        ['Bing 驗證', $status['bing_verify']],
                        ['社群連結 sameAs', $status['sameas'] > 0],
                        ['頁面 SEO 涵蓋', $stats['coverage'] >= 100],
                    ];
                @endphp
                @foreach($checks as [$label, $ok])
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="small">{{ $label }}</span>
                    @if($ok)
                        <span class="badge bg-success">已設定</span>
                    @else
                        <span class="badge bg-secondary">未設定</span>
                    @endif
                </div>
                @endforeach
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-1"><span class="small">頁面 SEO 涵蓋率</span><span class="small fw-semibold">{{ $stats['coverage'] }}%</span></div>
                    <div class="progress" style="height:8px;"><div class="progress-bar bg-success" style="width: {{ min($stats['coverage'],100) }}%"></div></div>
                    <div class="text-muted small mt-1">{{ $stats['page_seo'] }} / {{ $stats['pages'] * $stats['locales'] }}（頁面 × 語系）</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')<style>.icon-xl{width:2.2rem;height:2.2rem;}</style>@endpush
@endsection
