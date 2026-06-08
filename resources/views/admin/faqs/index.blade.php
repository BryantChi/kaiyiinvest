@extends('layouts.admin')

@section('title', 'FAQ 管理')

@php
    $breadcrumbs = [
        ['title' => 'FAQ 管理', 'url' => '#'],
    ];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-0">FAQ 管理</h2>
            <p class="text-muted mb-0">常見問題（多語）</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
            <svg class="icon me-1"><use xlink:href="/assets/icons/free.svg#cil-plus"></use></svg> 新增 FAQ
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width:60px;">排序</th>
                        <th>問題（預設語系）</th>
                        <th>分類</th>
                        <th>語系</th>
                        <th>狀態</th>
                        <th class="text-end">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                    @php $t = $faq->translation(\App\Support\LocaleService::default()); @endphp
                    <tr>
                        <td>{{ $faq->order }}</td>
                        <td>{{ $t?->question ?? '（未填預設語系）' }}</td>
                        <td>
                            @foreach(array_filter(explode(' ', (string) $faq->category)) as $cat)
                                <span class="badge bg-info text-dark">{{ $categories[$cat] ?? $cat }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($faq->translations as $tr)
                                <span class="badge bg-secondary">{{ $tr->locale }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge bg-success">啟用</span>
                            @else
                                <span class="badge bg-secondary">停用</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-primary">編輯</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="d-inline"
                                  onsubmit="return confirm('確定刪除此 FAQ？');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">刪除</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">尚無 FAQ</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($faqs->hasPages())
    <div class="card-footer">{{ $faqs->links() }}</div>
    @endif
</div>
@endsection
