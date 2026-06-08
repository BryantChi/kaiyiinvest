@extends('layouts.admin')

@section('title', '編輯用戶')

@php
    $breadcrumbs = [
        ['title' => '用戶管理', 'url' => route('admin.users.index')],
        ['title' => '編輯用戶', 'url' => '#']
    ];
@endphp

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">編輯用戶</h2>
        <p class="text-muted">修改用戶資訊</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <strong>基本資訊</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">姓名 <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">新密碼</label>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password">
                        <div class="form-text">留空表示不修改密碼</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">確認新密碼</label>
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <strong>角色設定</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">選擇角色</label>
                        @foreach($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="roles[]"
                                   value="{{ $role->name }}"
                                   id="role-{{ $role->id }}"
                                   {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-{{ $role->id }}">
                                {{ $role->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <strong>帳號狀態</strong>
                </div>
                <div class="card-body">
                    @if($user->id === auth()->id())
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked disabled>
                        <label class="form-check-label">啟用此帳號</label>
                    </div>
                    <div class="form-text text-muted">無法停用目前登入的帳號。</div>
                    @else
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                               id="is_active" name="is_active" value="1"
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">啟用此帳號</label>
                    </div>
                    <div class="form-text">停用後將無法登入，且在線 session 會被即時登出。</div>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <svg class="icon me-2">
                                <use xlink:href="/assets/icons/free.svg#cil-save"></use>
                            </svg>
                            更新
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light">取消</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
