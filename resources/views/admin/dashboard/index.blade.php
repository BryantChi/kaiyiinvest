@extends('layouts.admin')

@section('title', '儀表板')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="mb-4">
            <h2 class="mb-0">儀表板</h2>
            <p class="text-muted">歡迎回來，{{ auth()->user()->name }}!</p>
        </div>
    </div>
</div>

{{-- 統計卡片 --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-6 fw-semibold text-primary">{{ $stats['total_users'] ?? 0 }}</div>
                        <div class="text-muted small text-uppercase fw-semibold">用戶總數</div>
                    </div>
                    <div class="text-primary">
                        <svg class="icon icon-xl">
                            <use xlink:href="/assets/icons/free.svg#cil-people"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-6 fw-semibold text-success">{{ $stats['published_articles'] ?? 0 }}</div>
                        <div class="text-muted small text-uppercase fw-semibold">已發布文章</div>
                    </div>
                    <div class="text-success">
                        <svg class="icon icon-xl">
                            <use xlink:href="/assets/icons/free.svg#cil-newspaper"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-6 fw-semibold text-warning">{{ $stats['draft_articles'] ?? 0 }}</div>
                        <div class="text-muted small text-uppercase fw-semibold">草稿文章</div>
                    </div>
                    <div class="text-warning">
                        <svg class="icon icon-xl">
                            <use xlink:href="/assets/icons/free.svg#cil-pencil"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-6 fw-semibold text-info">{{ $stats['today_views'] ?? 0 }}</div>
                        <div class="text-muted small text-uppercase fw-semibold">今日瀏覽</div>
                    </div>
                    <div class="text-info">
                        <svg class="icon icon-xl">
                            <use xlink:href="/assets/icons/free.svg#cil-chart-line"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- 最近文章 --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <strong>最近文章</strong>
            </div>
            <div class="card-body p-0">
                @if($recentArticles && $recentArticles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @foreach($recentArticles as $article)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $article->title }}</div>
                                        <small class="text-muted">
                                            {{ $article->author->name ?? 'Unknown' }} •
                                            {{ $article->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-{{ $article->status_color }}">
                                            {{ $article->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📝</div>
                        <div>尚無文章</div>
                    </div>
                @endif
            </div>
            @if($recentArticles && $recentArticles->count() > 0)
            <div class="card-footer">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-link">
                    查看全部文章
                    <svg class="icon">
                        <use xlink:href="/assets/icons/free.svg#cil-arrow-right"></use>
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- 熱門文章 --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <strong>熱門文章</strong>
            </div>
            <div class="card-body p-0">
                @if($popularArticles && $popularArticles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                @foreach($popularArticles as $article)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $article->title }}</div>
                                        <small class="text-muted">
                                            {{ $article->category->name ?? 'Uncategorized' }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <div class="text-muted small">
                                            <svg class="icon">
                                                <use xlink:href="/assets/icons/free.svg#cil-info"></use>
                                            </svg>
                                            {{ number_format($article->views_count) }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📊</div>
                        <div>暫無數據</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- 每日瀏覽量圖表 --}}
@if(isset($dailyViews) && count($dailyViews) > 0)
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <strong>最近 7 天瀏覽量</strong>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="dailyViewsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('dailyViewsChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($dailyViews, 'label')) !!},
                datasets: [{
                    label: '瀏覽量',
                    data: {!! json_encode(array_column($dailyViews, 'count')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endif
@endsection
