@extends('layouts.admin')

@section('title', '分類管理')

@php
    $breadcrumbs = [
        ['title' => '分類管理', 'url' => '#']
    ];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="mb-0">分類管理</h2>
        <p class="text-muted">管理文章分類</p>
    </div>
    <div class="col-md-6 text-md-end">
        @can('create categories')
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <svg class="icon me-2">
                <use xlink:href="/assets/icons/free.svg#cil-plus"></use>
            </svg>
            新增分類
        </a>
        @endcan
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
            <div class="col-md-5">
                <input type="text"
                       class="form-control"
                       name="search"
                       placeholder="搜尋分類名稱或描述"
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status">
                    <option value="">全部狀態</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>啟用</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>停用</option>
                </select>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-secondary">
                    <svg class="icon">
                        <use xlink:href="/assets/icons/free.svg#cil-search"></use>
                    </svg>
                    搜尋
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">清除</a>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>分類名稱</th>
                        <th>父分類</th>
                        <th>文章數</th>
                        <th>狀態</th>
                        <th>排序</th>
                        <th>建立時間</th>
                        <th class="text-end">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            @if($category->icon)
                                <i class="{{ $category->icon }} me-2" style="color: {{ $category->color ?? '#6c757d' }}"></i>
                            @endif
                            <strong>{{ $category->name }}</strong>
                            @if($category->children_count > 0)
                                <span class="badge bg-info ms-2">{{ $category->children_count }} 子分類</span>
                            @endif
                        </td>
                        <td>
                            @if($category->parent)
                                <span class="badge bg-secondary">{{ $category->parent->name }}</span>
                            @else
                                <span class="text-muted">頂層分類</span>
                            @endif
                        </td>
                        <td>
                            <svg class="icon text-muted">
                                <use xlink:href="/assets/icons/free.svg#cil-file"></use>
                            </svg>
                            {{ $category->articles_count ?? 0 }}
                        </td>
                        <td>
                            @if($category->status === 'active')
                                <span class="badge bg-success">啟用</span>
                            @else
                                <span class="badge bg-secondary">停用</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $category->order }}</span>
                        </td>
                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                @can('view categories')
                                <a href="{{ route('admin.categories.show', $category) }}"
                                   class="btn btn-sm btn-light"
                                   data-coreui-toggle="tooltip"
                                   title="查看">
                                    <svg class="icon">
                                        <use xlink:href="/assets/icons/free.svg#cil-info"></use>
                                    </svg>
                                </a>
                                @endcan

                                @can('edit categories')
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-light"
                                   data-coreui-toggle="tooltip"
                                   title="編輯">
                                    <svg class="icon">
                                        <use xlink:href="/assets/icons/free.svg#cil-pencil"></use>
                                    </svg>
                                </a>
                                @endcan

                                @can('delete categories')
                                <form method="POST"
                                      action="{{ route('admin.categories.destroy', $category) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('確定要刪除此分類嗎？\n\n注意：\n- 此分類下的子分類也會被刪除\n- 已關聯的文章將變為未分類');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-light text-danger"
                                            data-coreui-toggle="tooltip"
                                            title="刪除"
                                            {{ ($category->children_count > 0 || ($category->articles_count ?? 0) > 0) ? 'disabled' : '' }}>
                                        <svg class="icon">
                                            <use xlink:href="/assets/icons/free.svg#cil-trash"></use>
                                        </svg>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">📁</div>
            <div>尚無分類資料</div>
            @can('create categories')
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-3">新增第一個分類</a>
            @endcan
        </div>
        @endif
    </div>

    @if($categories->hasPages())
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
    @endif
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <strong>分類樹狀結構</strong>
            </div>
            <div class="card-body">
                @if($tree->count() > 0)
                <div class="category-tree">
                    @foreach($tree as $category)
                        @include('admin.categories.partials.tree-item', ['category' => $category, 'level' => 0])
                    @endforeach
                </div>
                @else
                <p class="text-muted mb-0">尚無分類資料</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .category-tree {
        list-style: none;
        padding: 0;
    }
    .category-tree-item {
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        background: #f8f9fa;
        border-radius: 0.25rem;
        border-left: 3px solid #6c757d;
    }
    .category-tree-item.level-1 {
        margin-left: 2rem;
        background: #e9ecef;
    }
    .category-tree-item.level-2 {
        margin-left: 4rem;
        background: #dee2e6;
    }
    .category-tree-children {
        list-style: none;
        padding: 0;
        margin-top: 0.5rem;
    }
</style>
@endpush
@endsection
