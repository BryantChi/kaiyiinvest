{{-- 所見即所得編輯器（TinyMCE，自託管、由 Vite 打包，不使用 CDN）。
     初始化邏輯在 resources/js/richtext.js（含 .js-richtext 區塊式 / .js-richtext-inline 行內式兩種 flavor）。
     以 @once 確保多次 @include 只載入一次。 --}}
@once
@push('scripts')
    @vite('resources/js/richtext.js')
@endpush
@endonce
