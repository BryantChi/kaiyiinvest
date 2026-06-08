@php $locale = $locale ?? null; @endphp
<div class="row">
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">語系代碼 <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code', $locale?->code) }}" placeholder="如 ja、ko、fr" required>
                    <div class="form-text">建議用 BCP 47 代碼（zh-TW、en、vi、ja…）。此即網址前綴。</div>
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">名稱 <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $locale?->name) }}" placeholder="如 日本語" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">原生名稱（語言選單顯示用）</label>
                    <input type="text" name="native_name" class="form-control"
                           value="{{ old('native_name', $locale?->native_name) }}" placeholder="如 日本語">
                </div>
                <div class="mb-3">
                    <label class="form-label">排序</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $locale?->sort_order ?? 0) }}">
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                           {{ old('is_active', $locale?->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">啟用</label>
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_default" value="1" id="is_default"
                           {{ old('is_default', $locale?->is_default ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">設為預設語系（網址無前綴；將取代目前預設）</label>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">儲存</button>
            <a href="{{ route('admin.locales.index') }}" class="btn btn-light">取消</a>
        </div>
    </div>
</div>
