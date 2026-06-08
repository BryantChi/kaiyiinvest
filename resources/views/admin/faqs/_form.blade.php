@php
    $faq = $faq ?? null;
    $selectedCats = $faq ? array_filter(explode(' ', (string) $faq->category)) : [];
    $default = \App\Support\LocaleService::default();
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><strong>問答內容（各語系）</strong></div>
            <div class="card-body">
                <ul class="nav nav-pills mb-3" role="tablist">
                    @foreach($locales as $i => $loc)
                    <li class="nav-item">
                        <button class="nav-link {{ $i === 0 ? 'active' : '' }}" data-coreui-toggle="pill"
                                data-coreui-target="#loc-{{ $loc->code }}" type="button">
                            {{ $loc->native_name }}@if($loc->is_default)<span class="badge bg-secondary ms-1">預設</span>@endif
                        </button>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($locales as $i => $loc)
                    @php $tr = $faq?->translationFor($loc->code); @endphp
                    <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="loc-{{ $loc->code }}">
                        <div class="mb-3">
                            <label class="form-label">問題 @if($loc->code === $default)<span class="text-danger">*</span>@endif</label>
                            <input type="text" class="form-control @error('translations.'.$default.'.question') is-invalid @enderror"
                                   name="translations[{{ $loc->code }}][question]"
                                   value="{{ old('translations.'.$loc->code.'.question', $tr?->question) }}">
                            @if($loc->code === $default)
                                @error('translations.'.$default.'.question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">答案 @if($loc->code === $default)<span class="text-danger">*</span>@endif</label>
                            <textarea class="form-control js-richtext @error('translations.'.$default.'.answer') is-invalid @enderror" rows="6"
                                      name="translations[{{ $loc->code }}][answer]">{{ old('translations.'.$loc->code.'.answer', $tr?->answer) }}</textarea>
                            @if($loc->code === $default)
                                @error('translations.'.$default.'.answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @endif
                        </div>
                        <div class="form-text">非預設語系留空，前台會 fallback 至預設語系。</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><strong>設定</strong></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">分類（可複選，對應前台篩選）</label>
                    @foreach($categories as $key => $label)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="category[]" value="{{ $key }}"
                               id="cat-{{ $key }}" {{ in_array($key, old('category', $selectedCats)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat-{{ $key }}">{{ $label }} <small class="text-muted">({{ $key }})</small></label>
                    </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <label class="form-label">排序</label>
                    <input type="number" class="form-control" name="order" value="{{ old('order', $faq?->order ?? 0) }}">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                           {{ old('is_active', $faq?->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">啟用（前台顯示）</label>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body d-grid gap-2">
                <button type="submit" class="btn btn-primary">儲存</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-light">取消</a>
            </div>
        </div>
    </div>
</div>

@include('admin.partials.richtext-editor')
