@extends('layouts.admin')

@section('title', '工程師工具')

@php
    $breadcrumbs = [['title' => '工程師工具', 'url' => '#']];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">工程師工具</h2>
        <p class="text-muted mb-0">語系/Geo 開關與部署維運（僅工程師可見）</p>
    </div>
</div>

@if(session('deploy_output'))
<div class="card mb-3 border-info">
    <div class="card-header bg-info-subtle"><strong>指令輸出</strong></div>
    <div class="card-body">
        @if(session('maintenance_secret'))
        <div class="alert alert-warning">
            維護模式繞過網址（請保存，關閉前用它存取網站）：<br>
            <a href="{{ session('maintenance_secret') }}" target="_blank"><code>{{ session('maintenance_secret') }}</code></a>
        </div>
        @endif
        <pre class="mb-0" style="white-space:pre-wrap;font-size:.85rem;">{{ session('deploy_output') ?: '（無輸出）' }}</pre>
    </div>
</div>
@endif

<div class="row">
    {{-- 開關 --}}
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header"><strong>語系 / Geo 偵測開關</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.engineer.settings') }}">
                    @csrf
                    @method('PUT')
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="locale_auto_detect" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="locale_auto_detect"
                               name="locale_auto_detect" value="1" {{ $settings['locale_auto_detect'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="locale_auto_detect">
                            <strong>啟用語系自動偵測</strong><br>
                            <small class="text-muted">首次造訪依瀏覽器語言／IP 自動導向對應語系；關閉後一律停留在原網址。</small>
                        </label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="geoip_enabled" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="geoip_enabled"
                               name="geoip_enabled" value="1" {{ $settings['geoip_enabled'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="geoip_enabled">
                            <strong>啟用 IP 地區偵測（Geo）</strong><br>
                            <small class="text-muted">用 Cloudflare 標頭或 MaxMind 依 IP 判斷國家；關閉後只用瀏覽器語言。</small>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">儲存設定</button>
                </form>
            </div>
        </div>

        {{-- 系統資訊 --}}
        <div class="card mb-3">
            <div class="card-header"><strong>系統資訊</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th>Laravel</th><td>{{ $info['laravel'] }}</td></tr>
                    <tr><th>PHP</th><td>{{ $info['php'] }}</td></tr>
                    <tr><th>環境</th><td>{{ $info['env'] }}（debug {{ $info['debug'] }}）</td></tr>
                    <tr><th>MaxMind 金鑰</th><td>{!! $info['maxmind_key'] ? '<span class="badge bg-success">已設定</span>' : '<span class="badge bg-secondary">未設定</span>' !!}</td></tr>
                    <tr><th>GeoIP 資料庫</th><td>{!! $info['geoip_db'] ? '<span class="badge bg-success">已下載</span>' : '<span class="badge bg-warning text-dark">未下載</span>' !!}</td></tr>
                    <tr><th>維護模式</th><td>{!! $info['maintenance'] ? '<span class="badge bg-danger">維護中</span>' : '<span class="badge bg-success">運行中</span>' !!}</td></tr>
                </table>
            </div>
        </div>
    </div>

    {{-- 部署工具 --}}
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header"><strong>部署 / 維運工具</strong></div>
            <div class="card-body">
                @php
                    $tools = [
                        ['clear-cache', '清除所有快取', 'optimize:clear（設定/路由/視圖/快取）', 'btn-outline-secondary', false],
                        ['build-cache', '建立快取（上線最佳化）', 'config/route/view 快取', 'btn-outline-secondary', false],
                        ['migrate', '執行資料庫遷移', 'migrate --force', 'btn-outline-primary', true],
                        ['geoip-update', '更新 GeoIP 資料庫', '下載最新 MaxMind 資料庫（需金鑰）', 'btn-outline-info', false],
                        ['storage-link', '建立 storage 連結', 'storage:link', 'btn-outline-secondary', false],
                    ];
                @endphp
                <div class="d-grid gap-2">
                    @foreach($tools as [$action, $label, $desc, $cls, $confirm])
                    <form method="POST" action="{{ route('admin.engineer.deploy', $action) }}"
                          @if($confirm) onsubmit="return confirm('確定要執行：{{ $label }}？')" @endif>
                        @csrf
                        <button type="submit" class="btn {{ $cls }} w-100 text-start">
                            <strong>{{ $label }}</strong><br><small class="text-muted">{{ $desc }}</small>
                        </button>
                    </form>
                    @endforeach
                </div>

                <hr>
                <div class="d-grid gap-2">
                    @if($info['maintenance'])
                    <form method="POST" action="{{ route('admin.engineer.deploy', 'maintenance-off') }}">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">關閉維護模式（恢復網站）</button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.engineer.deploy', 'maintenance-on') }}"
                          onsubmit="return confirm('將使前台暫時無法存取（會提供繞過網址）。確定進入維護模式？')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">進入維護模式</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
