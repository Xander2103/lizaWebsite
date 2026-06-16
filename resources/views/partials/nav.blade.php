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
            <a href="#contact" class="btn btn-primary nav-cta-btn">
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
    @foreach(config('site.nav_items', []) as $item)
        <a href="{{ $item['href'] }}" class="nav-mobile-link">{{ $item['label'] }}</a>
    @endforeach

    @if(!empty(config('site.cta_primary')))
        <a href="#contact" class="btn btn-primary">{{ config('site.cta_primary') }}</a>
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
