@extends('layouts.admin')

@section('title', '頁面內容')

@php
    $breadcrumbs = [
        ['title' => '頁面內容', 'url' => '#'],
    ];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">頁面內容</h2>
        <p class="text-muted">編輯前台各頁的可編輯區塊（逐語系）</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>頁面</th>
                        <th>可編輯區塊</th>
                        <th class="text-end">編輯（依語系）</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                    <tr>
                        <td><strong>{{ $page->name }}</strong> <small class="text-muted">({{ $page->key }})</small></td>
                        <td>{{ $page->block_count }} 個</td>
                        <td class="text-end">
                            @foreach($locales as $loc)
                            <a href="{{ route('admin.content.edit', ['pageKey' => $page->key, 'locale' => $loc->code]) }}"
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
