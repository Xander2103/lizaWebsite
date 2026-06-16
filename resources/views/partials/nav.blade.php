<nav class="nav-bar" aria-label="Main navigation">
    <div class="nav-bar-inner">

        <a href="/" class="nav-logo" aria-label="{{ config('site.name') }}">
            @if(config('images.logo'))
                <img src="{{ asset(config('images.logo')) }}" alt="{{ config('site.name') }}" height="40">
            @else
                <span class="nav-logo-name">{{ config('site.name') }}</span>
                @if(!empty(config('site.nav_subtitle')))
                    <span class="nav-logo-services">{{ config('site.nav_subtitle') }}</span>
                @endif
            @endif
        </a>

        <ul class="nav-links" role="list">
            @foreach(config('site.nav_items', []) as $item)
                <li><a href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
            @endforeach
        </ul>

        @if(!empty(config('site.cta_primary')))
            <a href="{{ config('site.appointment_url') }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary nav-cta-btn">
                {{ config('site.cta_primary') }}
            </a>
        @endif

        <button
            class="nav-toggle"
            id="nav-toggle"
            aria-label="Open menu"
            aria-expanded="false"
            aria-controls="nav-mobile-panel"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</nav>

<div
    class="nav-mobile-panel"
    id="nav-mobile-panel"
    role="dialog"
    aria-modal="true"
    aria-label="Mobile menu"
    aria-hidden="true"
>
    <div class="nav-mobile-brand">
        <span class="nav-mobile-brand-name">{{ config('site.name') }}</span>
        @if(!empty(config('site.nav_subtitle')))
            <span class="nav-mobile-brand-subtitle">{{ config('site.nav_subtitle') }}</span>
        @endif
    </div>

    <div class="nav-mobile-links">
        @foreach(config('site.nav_items', []) as $item)
            <a href="{{ $item['href'] }}" class="nav-mobile-link">{{ $item['label'] }}</a>
        @endforeach

        @if(!empty(config('site.cta_primary')))
            <a href="{{ config('site.appointment_url') }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary nav-mobile-cta">{{ config('site.cta_primary') }}</a>
        @endif
    </div>

    @if(!empty(config('contact.instagram_handle')))
        <a href="{{ config('contact.instagram_url', '#') }}" target="_blank" rel="noopener noreferrer" class="nav-mobile-instagram">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
            </svg>
            {{ config('contact.instagram_handle') }}
        </a>
    @endif
</div>

@push('scripts')
<script>
(function () {
    var toggle = document.getElementById('nav-toggle');
    var panel  = document.getElementById('nav-mobile-panel');
    if (!toggle || !panel) return;

    function openMenu() {
        panel.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
        panel.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        panel.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        panel.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', function () {
        panel.classList.contains('is-open') ? closeMenu() : openMenu();
    });

    panel.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });
}());
</script>
@endpush
