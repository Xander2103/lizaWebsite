<footer class="footer-bar">
    <div class="client-container">
        <div class="footer-grid">

            <div class="footer-brand">
                <p class="footer-brand-name">{{ config('site.name') }}</p>
                @if(!empty(config('site.nav_subtitle')))
                    <p class="footer-brand-subtitle">{{ config('site.nav_subtitle') }}</p>
                @endif
                @if(!empty(config('site.hero_subheading')))
                    <p class="footer-brand-desc">{{ config('site.hero_subheading') }}</p>
                @endif
                @if(!empty(config('contact.instagram_handle')))
                    <a href="{{ config('contact.instagram_url', '#') }}" target="_blank" rel="noopener noreferrer" class="footer-instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                        {{ config('contact.instagram_handle') }}
                    </a>
                @endif
                <a href="{{ route('privacy.policy') }}" class="footer-privacy-link">Privacy Policy</a>
            </div>

            <div>
                <p class="footer-label">Services</p>
                <ul class="footer-nav-list" role="list">
                    @foreach(config('site.footer_nav_items', []) as $item)
                        <li>
                            <a href="{{ $item['href'] }}"
                               @if(!empty($item['target'])) target="{{ $item['target'] }}" rel="noopener noreferrer" @endif>{{ $item['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="footer-label">Contact &amp; Location</p>
                <ul class="footer-contact-list" role="list">
                    @if(!empty(config('contact.location_name')))
                        <li class="footer-contact-strong">{{ config('contact.location_name') }}</li>
                    @endif
                    @if(!empty(config('contact.address_line1')))
                        <li>{{ config('contact.address_line1') }}</li>
                    @endif
                    @if(!empty(config('contact.address_line2')))
                        <li>{{ config('contact.address_line2') }}</li>
                    @endif
                    @if(!empty(config('contact.phone')))
                        <li><a href="tel:{{ config('contact.phone') }}">{{ config('contact.phone') }}</a></li>
                    @endif
                    @if(!empty(config('contact.phone_mobile')))
                        <li><a href="tel:{{ config('contact.phone_mobile') }}">{{ config('contact.phone_mobile') }}</a></li>
                    @endif
                    @if(!empty(config('contact.email')))
                        <li><a href="mailto:{{ config('contact.email') }}">{{ config('contact.email') }}</a></li>
                    @endif
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <span class="footer-bottom-copy">
                © {{ date('Y') }} Dr Sue-Liza Eta
                <span class="footer-legal-sep">·</span> VAT: BE0793838003
                <span class="footer-legal-sep">·</span> <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                <span class="footer-legal-sep">·</span> <a href="{{ route('legal.notice') }}">Legal Notice</a>
            </span>
            @if(!empty(config('site.developer_name')))
                <span class="footer-bottom-credit">Made by <a href="{{ config('site.developer_url') }}" target="_blank" rel="noopener noreferrer">{{ config('site.developer_name') }}</a></span>
            @endif
            @if(!empty(config('contact.footer_location_line')))
                <span class="footer-bottom-location">{{ config('contact.footer_location_line') }}</span>
            @endif
        </div>
    </div>
</footer>
