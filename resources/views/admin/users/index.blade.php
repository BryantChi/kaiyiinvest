@extends('layouts.admin')

@section('title', '用戶管理')

@php
    $breadcrumbs = [
        ['title' => '用戶管理', 'url' => '#']
    ];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2 class="mb-0">用戶管理</h2>
        <p class="text-muted">管理系統用戶與角色權限</p>
    </div>
    <div class="col-md-6 text-md-end">
        @can('create users')
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <svg class="icon me-2">
                <use xlink:href="/assets/icons/free.svg#cil-user-plus"></use>
            </svg>
            新增用戶
        </a>
        @endcan
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text"
                       class="form-control"
                       name="search"
                       placeholder="搜尋用戶名稱或 Email"
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="role">
                    <option value="">全部角色</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto">
                <button type="submit" class="btn btn-secondary">
                    <svg class="icon">
                        <use xlink:href="/assets/icons/free.svg#cil-search"></use>
                    </svg>
                    搜尋
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-light">清除</a>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>Email</th>
                        <th>角色</th>
                        <th>狀態</th>
                        <th>建立時間</th>
                        <th class="text-end">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->avatar }}" class="avatar avatar-sm me-2" alt="{{ $user->name }}">
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-info me-1">{{ $role->name }}</span>
                            @endforeach
                            @if($user->roles->isEmpty())
                                <span class="text-muted">無角色</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">啟用</span>
                            @else
                                <span class="badge bg-secondary">停用</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                @can('view users')
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-sm btn-light"
                                   data-coreui-toggle="tooltip"
                                   title="查看">
                                    <svg class="icon">
                                        <use xlink:href="/assets/icons/free.svg#cil-info"></use>
                                    </svg>
                                </a>
                                @endcan

                                @can('edit users')
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-sm btn-light"
                                   data-coreui-toggle="tooltip"
                                   title="編輯">
                                    <svg class="icon">
                                        <use xlink:href="/assets/icons/free.svg#cil-pencil"></use>
                                    </svg>
                                </a>

                                @if($user->id !== auth()->id() && !$user->isEngineer())
                                <form method="POST"
                                      action="{{ route('admin.users.toggle-active', $user) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('{{ $user->is_active ? '確定要停用「' . $user->name . '」嗎？停用後將無法登入。' : '確定要啟用「' . $user->name . '」嗎？' }}');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-sm btn-light {{ $user->is_active ? 'text-secondary' : 'text-success' }}"
                                            data-coreui-toggle="tooltip"
                                            title="{{ $user->is_active ? '停用帳號' : '啟用帳號' }}">
                                        <svg class="icon">
                                            <use xlink:href="/assets/icons/free.svg#{{ $user->is_active ? 'cil-ban' : 'cil-check-circle' }}"></use>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                @endcan

                                @php
                                    $me = auth()->user();
                                    $canImpersonate = ($me->isEngineer() || $me->hasRole('super-admin'))
                                        && $user->id !== $me->id
                                        && ! $user->isEngineer()
                                        && (! $user->hasRole('super-admin') || $me->isEngineer())
                                        && ! is_impersonating();
                                @endphp
                                @if($canImpersonate)
                                <form method="POST"
                                      action="{{ route('admin.users.impersonate', $user) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('以「{{ $user->name }}」的身分登入？你可隨時返回原帳號。');">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm btn-light text-primary"
                                            data-coreui-toggle="tooltip"
                                            title="模擬登入">
                                        <svg class="icon">
                                            <use xlink:href="/assets/icons/free.svg#cil-user"></use>
                                        </svg>
                                    </button>
                                </form>
                                @endif

                                @can('delete users')
                                @if($user->id !== auth()->id() && !$user->isEngineer())
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('確定要刪除此用戶嗎？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-light text-danger"
                                            data-coreui-toggle="tooltip"
                                            title="刪除">
                                        <svg class="icon">
                                            <use xlink:href="/assets/icons/free.svg#cil-trash"></use>
                                        </svg>
                                    </button>
                                </form>
                                @endif
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
            <div class="empty-state-icon">👥</div>
            <div>尚無用戶資料</div>
            @can('create users')
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-3">新增第一個用戶</a>
            @endcan
        </div>
        @endif
    </div>

    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
