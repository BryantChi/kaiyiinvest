@extends('layouts.guest')

@section('title', '登入')

@section('content')
<div class="card">
    <h1 class="card-title">登入後台</h1>
    <p class="card-desc">請輸入您的帳號以繼續</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            登入失敗
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label for="login" class="field-label">帳號</label>
            <div class="input-shell @error('login') has-error @enderror">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
                </svg>
                <input type="text" id="login" name="login" value="{{ old('login') }}"
                       placeholder="Email 或使用者名稱" required autofocus autocomplete="username">
            </div>
            @error('login')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="password" class="field-label">密碼</label>
            <div class="input-shell @error('password') has-error @enderror">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <rect x="4" y="10" width="16" height="10" rx="2"/>
                    <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                </svg>
                <input type="password" id="password" name="password"
                       placeholder="請輸入密碼" required autocomplete="current-password">
            </div>
            @error('password')<div class="field-error">{{ $message }}</div>@enderror
        </div>

        <div class="row-between">
            <label class="check">
                <input type="checkbox" name="remember" value="1">
                記住我
            </label>
        </div>

        <button type="submit" class="btn-submit">登入</button>
    </form>
</div>
@endsection
