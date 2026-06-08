@extends('layouts.admin')

@section('title', '編輯設定')

@php $breadcrumbs = [['title' => '系統設定', 'url' => route('admin.settings.index')], ['title' => '編輯設定', 'url' => '#']]; @endphp

@section('content')
<div class="row mb-4"><div class="col-12">
    <h2 class="mb-0">編輯設定</h2>
    <p class="text-muted mb-0"><code>{{ $setting->group }}.{{ $setting->key }}</code></p>
</div></div>

<form method="POST" action="{{ route('admin.settings.update', $setting) }}">
    @csrf @method('PUT')
    <div class="row"><div class="col-lg-8">
        <div class="card mb-3"><div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">群組</label>
                    <input type="text" class="form-control" value="{{ $setting->group }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">鍵（key）</label>
                    <input type="text" class="form-control" value="{{ $setting->key }}" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">型別</label>
                <input type="text" class="form-control" value="{{ $setting->type }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">值 <span class="text-danger">*</span></label>
                <textarea name="value" rows="3" class="form-control @error('value') is-invalid @enderror" required>{{ old('value', $setting->value) }}</textarea>
                @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">說明</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $setting->description) }}">
            </div>
            @unless($setting->is_editable)
            <div class="alert alert-warning mb-0">此設定標記為不可編輯，儲存將被拒絕。</div>
            @endunless
        </div></div>
        <div class="mb-4">
            <button class="btn btn-primary" {{ $setting->is_editable ? '' : 'disabled' }}>更新</button>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-light">取消</a>
        </div>
    </div></div>
</form>
@endsection
