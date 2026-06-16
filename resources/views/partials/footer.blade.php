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
                        {{ config('contact.instagram_handle') }}
                    </a>
                @endif
            </div>

            <div>
                <p class="footer-label">Services</p>
                <ul class="footer-nav-list" role="list">
                    @foreach(config('site.footer_nav_items', []) as $item)
                        <li><a href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
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
            <span>{{ config('site.footer_text') }}</span>
            @if(!empty(config('contact.footer_location_line')))
                <span>{{ config('contact.footer_location_line') }}</span>
            @endif
        </div>
    </div>
</footer>
