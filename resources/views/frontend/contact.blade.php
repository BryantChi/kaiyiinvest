@extends('frontend.layouts.app')

@section('title', '聯絡我們 | 楷懿國際投資')
@section('meta_description', '聯絡楷懿國際投資 — 越南河內、海防據點，台灣／越南聯絡電話與 Email。')
@section('meta_keywords', '聯絡楷懿,越南據點,河內,海防,不動產諮詢,聯絡電話')
@section('canonical', 'https://kaiyiinvest.com/contact.html')

@section('og_title', '聯絡我們 | 楷懿國際投資')
@section('og_description', '聯絡楷懿國際投資 — 越南河內、海防據點，台灣／越南聯絡電話與 Email。')

@section('twitter_title', '聯絡我們 | 楷懿國際投資')
@section('twitter_description', '聯絡楷懿國際投資 — 越南河內、海防據點，台灣／越南聯絡電話與 Email。')

@push('page-css')
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}?v=20260605">
@endpush

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-bg"
            style="background-image: url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1920&q=80');">
        </div>
        <div class="page-header-overlay"></div>
        <div class="page-header-content">
            <h1>{{ cb('contact','header.title') }}</h1>
            <p>{{ cb('contact','header.subtitle') }}</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact-section">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Info -->
                <div class="contact-info">
                    <div class="section-header" style="text-align: left; margin-bottom: 2rem;">
                        <p class="section-subtitle">{{ cb('contact','info.section_subtitle') }}</p>
                        <h2 class="section-title">{{ cb('contact','info.section_title') }}</h2>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ cb('contact','info.addr_label') }}</h4>
                            <p class="address-list">
                                <span><a href="https://maps.app.goo.gl/UH9iwxsFqonbLx2D8?g_st=il" target="_blank" rel="noopener">{{ cb('global','contact.addr_hanoi') }}</a></span>
                                <span><a href="https://maps.app.goo.gl/1r2e87E8h971Kisu7?g_st=il" target="_blank" rel="noopener">{{ cb('global','contact.addr_haiphong') }}</a></span>
                            </p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ cb('contact','info.phone_label') }}</h4>
                            <p>{{ cb('global','contact.label_tw') }} <a href="tel:{{ preg_replace('/[^0-9+]/', '', cb('global','contact.phone_tw')) }}">{{ cb('global','contact.phone_tw') }}</a><br>{{ cb('global','contact.label_vn') }} <a href="tel:{{ preg_replace('/[^0-9+]/', '', cb('global','contact.phone_vn')) }}">{{ cb('global','contact.phone_vn') }}</a></p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ cb('contact','info.email_label') }}</h4>
                            <p>{{ cb('global','contact.email') }}</p>
                        </div>
                    </div>

                    <!-- <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <h4>營業時間</h4>
                            <p>週一至週五 09:00 - 18:00<br>週六 10:00 - 17:00</p>
                        </div>
                    </div> -->

                    <div class="social-links">
                        @foreach(['facebook' => 'fa-facebook-f', 'instagram' => 'fa-instagram', 'linkedin' => 'fa-linkedin-in', 'youtube' => 'fa-youtube'] as $sKey => $sIcon)
                            @if(cb('global', 'social.' . $sKey))
                            <a href="{{ cb('global', 'social.' . $sKey) }}" class="social-link" target="_blank" rel="noopener"><i class="fab {{ $sIcon }}"></i></a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    @if(session('success'))
                        <div class="alert alert-success" style="padding:1rem;margin-bottom:1rem;background:#e6f4ea;border:1px solid #34a853;border-radius:6px;color:#1e7e34;">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" style="padding:1rem;margin-bottom:1rem;background:#fdecea;border:1px solid #dc3545;border-radius:6px;color:#b02a37;">
                            <ul style="margin:0;padding-left:1.2rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="contact-form" id="contactForm" method="POST" action="{{ localized_route('frontend.contact.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ cb('contact', 'form.name_label') }} *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">{{ cb('contact', 'form.email_label') }} *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ cb('contact', 'form.phone_label') }}</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">{{ cb('contact', 'form.subject_label') }} *</label>
                            <select id="subject" name="subject" required>
                                <option value="">{{ cb('contact', 'form.subject_placeholder') }}</option>
                                {{-- 鍵=送出/儲存的值（保持中文不變，避免影響既有資料與信件）；值=顯示用的 cb key（多語） --}}
                                @foreach(['不動產代理' => 'form.opt_real_estate', '工業地產' => 'form.opt_industrial', '專業諮詢' => 'form.opt_consulting', '其他服務' => 'form.opt_other', '一般詢問' => 'form.opt_general'] as $val => $optKey)
                                <option value="{{ $val }}" {{ old('subject') === $val ? 'selected' : '' }}>{{ cb('contact', $optKey) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">{{ cb('contact', 'form.message_label') }} *</label>
                            <textarea id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">{{ cb('contact', 'form.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="map-grid">
            <div class="map-container">
                <div class="map-label">{{ cb('contact','map.hanoi') }}</div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.8707335308873!2d105.9528974!3d20.997818199999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135a96b264e7343%3A0x8a508306b94400f!2zQ1RZIFROSEggVVBTVU4gVk4g5aSp5o-a6LKs5Lu75pyJ6ZmQ5YWs5Y-4!5e0!3m2!1szh-TW!2stw!4v1780487884989!5m2!1szh-TW!2stw"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
            <div class="map-container">
                <div class="map-label">{{ cb('contact','map.haiphong') }}</div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3729.2201069898724!2d106.69165989999999!3d20.822816499999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a710072aa8995%3A0x300de8030c9ebd42!2zQ8OUTkcgVFkgVE5ISCDEkOG6plUgVMavIFFV4buQQyBU4bq-IEtBSVlJIOalt-aHv-Wci-mam-aKleizh-aciemZkOWFrOWPuA!5e0!3m2!1szh-TW!2stw!4v1780487943221!5m2!1szh-TW!2stw"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </section>
@endsection

@push('page-js')
    <script src="{{ asset('assets/js/contact.js') }}?v=20260605"></script>
@endpush

