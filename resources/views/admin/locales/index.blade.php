@extends('layouts.admin')

@section('title', '語系管理')

@php
    $breadcrumbs = [['title' => '語系管理', 'url' => '#']];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-0">語系管理</h2>
            <p class="text-muted mb-0">設定前台支援的語言（預設語系網址無前綴，其餘以 /代碼 前綴）</p>
        </div>
        <a href="{{ route('admin.locales.create') }}" class="btn btn-primary">新增語系</a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>排序</th><th>代碼</th><th>名稱</th><th>原生名稱</th><th>預設</th><th>啟用</th>
                        <th class="text-end">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locales as $loc)
                    <tr>
                        <td>{{ $loc->sort_order }}</td>
                        <td><code>{{ $loc->code }}</code></td>
                        <td>{{ $loc->name }}</td>
                        <td>{{ $loc->native_name }}</td>
                        <td>@if($loc->is_default)<span class="badge bg-primary">預設</span>@endif</td>
                        <td>@if($loc->is_active)<span class="badge bg-success">啟用</span>@else<span class="badge bg-secondary">停用</span>@endif</td>
                        <td class="text-end">
                            <a href="{{ route('admin.locales.edit', $loc) }}" class="btn btn-sm btn-outline-primary">編輯</a>
                            @unless($loc->is_default)
                            <form method="POST" action="{{ route('admin.locales.destroy', $loc) }}" class="d-inline"
                                  onsubmit="return confirm('確定刪除此語系？該語系既有內容/SEO 將不再顯示。');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">刪除</button>
                            </form>
                            @endunless
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="alert alert-info mt-3">
    新增/停用語系後即時生效於前台；若曾執行 <code>php artisan route:cache</code> 或 <code>config:cache</code>，請重新執行以套用新語系的路由與內容設定。
</div>
@endsection
