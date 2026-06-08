{{-- 搜尋引擎驗證 + 分析追蹤（GA4 / GTM）。皆由後台「網站 SEO 設定」控制，有值才輸出。 --}}
@php
    $ga4 = \App\Support\Seo::ga4Id();
    $gtm = \App\Support\Seo::gtmId();
@endphp

@if($code = \App\Support\Seo::googleVerification())
<meta name="google-site-verification" content="{{ $code }}">
@endif
@if($code = \App\Support\Seo::bingVerification())
<meta name="msvalidate.01" content="{{ $code }}">
@endif
@if($code = \App\Support\Seo::yandexVerification())
<meta name="yandex-verification" content="{{ $code }}">
@endif

@if($gtm)
{{-- Google Tag Manager --}}
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $gtm }}');</script>
@elseif($ga4)
{{-- Google Analytics 4 --}}
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4 }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ $ga4 }}');
</script>
@endif
