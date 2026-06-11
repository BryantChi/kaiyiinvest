@extends('layouts.admin')

@section('title', '頁面 SEO - ' . $page->name)

@php
    $breadcrumbs = [
        ['title' => 'SEO 管理', 'url' => route('admin.seo.index')],
        ['title' => '頁面 SEO', 'url' => route('admin.seo.pages')],
        ['title' => $page->name, 'url' => '#'],
    ];
    $schemaText = $seo && $seo->schema_org
        ? json_encode($seo->schema_org, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        : '';
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">頁面 SEO：{{ $page->name }}</h2>
        <p class="text-muted mb-0">留空欄位前台會 fallback 至預設語系或該頁原始靜態值</p>
    </div>
</div>

{{-- 語系切換 --}}
<ul class="nav nav-pills mb-3">
    @foreach($locales as $loc)
    <li class="nav-item">
        <a class="nav-link {{ $loc->code === $locale ? 'active' : '' }}"
           href="{{ route('admin.seo.pages.edit', ['pageKey' => $page->key, 'locale' => $loc->code]) }}">
            {{ $loc->native_name }}@if($loc->is_default)<span class="badge bg-secondary ms-1">預設</span>@endif
        </a>
    </li>
    @endforeach
</ul>

<form method="POST" action="{{ route('admin.seo.pages.update', ['pageKey' => $page->key, 'locale' => $locale]) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header"><strong>基本 Meta</strong></div>
                <div class="card-body">
                    @php
                        $fields = [
                            'meta_title' => ['Meta 標題', 'text'],
                            'meta_description' => ['Meta 描述', 'textarea'],
                            'meta_keywords' => ['關鍵字（逗號分隔）', 'text'],
                            'canonical_url' => ['Canonical URL（留空＝目前網址）', 'text'],
                            'meta_robots' => ['Robots（如 index, follow）', 'text'],
                        ];
                    @endphp
                    @foreach($fields as $name => [$label, $type])
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>
                        @if($type === 'textarea')
                        <textarea name="{{ $name }}" rows="3" class="form-control @error($name) is-invalid @enderror" @if(in_array($name, ['meta_title','meta_description'])) data-seo-counter="{{ $name }}" @endif>{{ old($name, $seo->$name ?? '') }}</textarea>
                        @else
                        <input type="text" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror" value="{{ old($name, $seo->$name ?? '') }}" @if(in_array($name, ['meta_title','meta_description'])) data-seo-counter="{{ $name }}" @endif>
                        @endif
                        @if(in_array($name, ['meta_title','meta_description']))
                        <div class="form-text seo-counter" data-counter-for="{{ $name }}"></div>
                        @endif
                        @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><strong>結構化資料 JSON-LD（GEO / AEO）</strong></div>
                <div class="card-body">
                    <div class="mb-2">
                        <textarea name="schema_org" rows="10" class="form-control font-monospace @error('schema_org') is-invalid @enderror"
                                  placeholder='{"@context":"https://schema.org","@type":"WebPage", ...}'>{{ old('schema_org', $schemaText) }}</textarea>
                        @error('schema_org')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-text">填入合法 JSON。此區塊會額外輸出於頁面（補充原頁面既有的結構化資料）。</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header"><strong>Open Graph</strong></div>
                <div class="card-body">
                    @foreach(['og_title' => 'OG 標題', 'og_description' => 'OG 描述', 'og_image' => 'OG 圖片（路徑或網址）'] as $name => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>
                        @if($name === 'og_description')
                        <textarea name="{{ $name }}" rows="2" class="form-control">{{ old($name, $seo->$name ?? '') }}</textarea>
                        @else
                        <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name, $seo->$name ?? '') }}">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><strong>Twitter Card</strong></div>
                <div class="card-body">
                    @foreach(['twitter_title' => 'Twitter 標題', 'twitter_description' => 'Twitter 描述', 'twitter_image' => 'Twitter 圖片', 'twitter_card' => 'Card 類型'] as $name => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>
                        @if($name === 'twitter_description')
                        <textarea name="{{ $name }}" rows="2" class="form-control">{{ old($name, $seo->$name ?? '') }}</textarea>
                        @else
                        <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name, $seo->$name ?? '') }}">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon me-2"><use xlink:href="/assets/icons/free.svg#cil-save"></use></svg>
                        儲存（{{ $locale }}）
                    </button>
                    <a href="{{ route('admin.seo.pages') }}" class="btn btn-light">返回</a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    (function () {
        var limits = {
            meta_title: { min: {{ config('seo.limits.title.min') }}, rec: {{ config('seo.limits.title.recommended') }}, max: {{ config('seo.limits.title.max') }} },
            meta_description: { min: {{ config('seo.limits.description.min') }}, rec: {{ config('seo.limits.description.recommended') }}, max: {{ config('seo.limits.description.max') }} }
        };
        document.querySelectorAll('[data-seo-counter]').forEach(function (el) {
            var key = el.getAttribute('data-seo-counter');
            var lim = limits[key];
            var out = document.querySelector('[data-counter-for="' + key + '"]');
            if (!lim || !out) return;
            function update() {
                var n = (el.value || '').length;
                var ok = n >= lim.min && n <= lim.rec;
                var warn = n > lim.rec && n <= lim.max;
                var color = ok ? '#2e7d32' : (warn || (n > 0 && n < lim.min) ? '#b8860b' : (n > lim.max ? '#c62828' : '#888'));
                out.style.color = color;
                out.textContent = n + ' 字元（建議 ' + lim.min + '–' + lim.rec + '）'
                    + (n > lim.max ? ' · 過長' : (n > 0 && n < lim.min ? ' · 偏短' : (ok ? ' · 適中' : '')));
            }
            el.addEventListener('input', update);
            update();
        });
    })();
</script>
@endpush
@endsection
