@extends('layouts.admin')

@section('title', '頁面 SEO')

@php
    $breadcrumbs = [
        ['title' => 'SEO 管理', 'url' => route('admin.seo.index')],
        ['title' => '頁面 SEO', 'url' => '#'],
    ];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">頁面 SEO</h2>
        <p class="text-muted">設定前台各頁、各語系的 Meta / OG / Twitter / 結構化資料（JSON-LD）</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>頁面</th>
                        <th class="text-end">編輯 SEO（依語系）</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                    <tr>
                        <td><strong>{{ $page->name }}</strong> <small class="text-muted">({{ $page->key }})</small></td>
                        <td class="text-end">
                            @foreach($locales as $loc)
                            <a href="{{ route('admin.seo.pages.edit', ['pageKey' => $page->key, 'locale' => $loc->code]) }}"
                               class="btn btn-sm btn-outline-primary">{{ $loc->native_name }}</a>
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
