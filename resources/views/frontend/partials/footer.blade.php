{{-- 前台頁尾。原 HTML 首頁未顯示 footer，由 layout 的 $hideFooter 控制。內容用 cb('global',…) 可編輯 --}}
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>{{ cb('global', 'company.name') }}</h4>
                <p>{!! nl2br(e(cb('global', 'company.tagline'))) !!}</p>
            </div>
            <div class="footer-col">
                <h4>{{ cb('global', 'footer.quick_links') }}</h4>
                <ul>
                    <li><a href="{{ localized_route('frontend.home') }}">{{ cb('global', 'nav.home') }}</a></li>
                    <li><a href="{{ localized_route('frontend.about') }}">{{ cb('global', 'nav.about') }}</a></li>
                    <li><a href="{{ localized_route('frontend.services') }}">{{ cb('global', 'nav.services') }}</a></li>
                    <li><a href="{{ localized_route('frontend.contact') }}">{{ cb('global', 'nav.contact') }}</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>{{ cb('global', 'footer.contact_info') }}</h4>
                <p class="footer-contact">
                    <span><i class="fas fa-phone"></i> {{ cb('global', 'contact.label_tw') }} <a href="tel:{{ preg_replace('/[^0-9+]/', '', cb('global', 'contact.phone_tw')) }}">{{ cb('global', 'contact.phone_tw') }}</a></span>
                    <span><i class="fas fa-phone"></i> {{ cb('global', 'contact.label_vn') }} <a href="tel:{{ preg_replace('/[^0-9+]/', '', cb('global', 'contact.phone_vn')) }}">{{ cb('global', 'contact.phone_vn') }}</a></span>
                    <span><i class="fas fa-envelope"></i> {{ cb('global', 'contact.email') }}</span>
                    <span><i class="fas fa-map-marker-alt"></i> <a href="https://maps.app.goo.gl/UH9iwxsFqonbLx2D8?g_st=il" target="_blank" rel="noopener">{{ cb('global', 'contact.addr_hanoi') }}</a></span>
                    <span><i class="fas fa-map-marker-alt"></i> <a href="https://maps.app.goo.gl/1r2e87E8h971Kisu7?g_st=il" target="_blank" rel="noopener">{{ cb('global', 'contact.addr_haiphong') }}</a></span>
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ cb('global', 'footer.copyright') }}</p>
        </div>
    </div>
</footer>
