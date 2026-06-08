@extends('layouts.admin')

@section('title', '新增自訂設定')

@php $breadcrumbs = [['title' => '系統設定', 'url' => route('admin.settings.index')], ['title' => '新增自訂設定', 'url' => '#']]; @endphp

@section('content')
<div class="row mb-4"><div class="col-12">
    <h2 class="mb-0">新增自訂設定</h2>
    <p class="text-muted mb-0">建立 key-value 形式的自訂設定項</p>
</div></div>

<form method="POST" action="{{ route('admin.settings.store') }}">
    @csrf
    <div class="row"><div class="col-lg-8">
        <div class="card mb-3"><div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">群組 <span class="text-danger">*</span></label>
                    <input type="text" name="group" class="form-control @error('group') is-invalid @enderror" value="{{ old('group', 'general') }}" required>
                    @error('group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">鍵（key） <span class="text-danger">*</span></label>
                    <input type="text" name="key" class="form-control @error('key') is-invalid @enderror" value="{{ old('key') }}" required>
                    @error('key')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">型別 <span class="text-danger">*</span></label>
                <select name="type" class="form-select">
                    @foreach(['string' => '文字', 'integer' => '整數', 'boolean' => '布林', 'array' => '陣列', 'json' => 'JSON'] as $v => $l)
                    <option value="{{ $v }}" {{ old('type', 'string') === $v ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">值 <span class="text-danger">*</span></label>
                <textarea name="value" rows="3" class="form-control @error('value') is-invalid @enderror">{{ old('value') }}</textarea>
                @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">說明</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}">
            </div>
            <div class="form-check form-switch mb-2">
                <input type="hidden" name="is_public" value="0">
                <input class="form-check-input" type="checkbox" name="is_public" value="1" id="is_public" {{ old('is_public') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_public">公開（前台可讀）</label>
            </div>
            <div class="form-check form-switch">
                <input type="hidden" name="is_editable" value="0">
                <input class="form-check-input" type="checkbox" name="is_editable" value="1" id="is_editable" {{ old('is_editable', '1') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_editable">可編輯</label>
            </div>
        </div></div>
        <div class="mb-4">
            <button class="btn btn-primary">建立</button>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-light">取消</a>
        </div>
    </div></div>
</form>
@endsection
