@php
    $navItems = [
        ['route' => 'morris',      'key' => 'nav.morris',      'ar' => 'وليام موريس',     'en' => 'William Morris', 'protected' => false],
        ['route' => 'fabrics',     'key' => 'nav.fabrics',     'ar' => 'الأقمشة',          'en' => 'Fabrics',        'protected' => false],
        ['route' => 'technique',   'key' => 'nav.technique',   'ar' => 'التقنية',          'en' => 'Technique',      'protected' => false],
        ['route' => 'design-tool', 'key' => 'nav.design_tool', 'ar' => 'أداة التصميم',    'en' => 'Design Tool',    'protected' => true],
        ['route' => 'survey',      'key' => 'nav.survey',      'ar' => 'الاستبيان',        'en' => 'Survey',         'protected' => true],
    ];
    $isArabic      = session('lang', 'ar') === 'ar';
    $isLoggedIn    = session()->has('participant_id');
@endphp

<header class="site-header">
    <div class="container site-header__inner">
        <a class="brand" href="{{ route('home') }}">
            <span class="brand__title">Rawnaq</span>
            <span class="brand__subtitle" data-lang-key="app.tagline">{{ $isArabic ? 'تجربة تصميم الأقمشة المستدامة' : 'Sustainable Fabric Design Experience' }}</span>
        </a>



        <div class="site-header__actions" data-header-actions>
            <div class="language-switcher" aria-label="Language switcher">
                <button class="language-switcher__button" type="button" data-lang-switch="ar">AR</button>
                <button class="language-switcher__button" type="button" data-lang-switch="en">EN</button>
            </div>

            @if ($isLoggedIn)
                <div class="participant-chip">
                    <span class="participant-chip__name">{{ session('participant_name') }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="button-secondary" type="submit" data-lang-key="nav.logout">
                        {{ $isArabic ? 'خروج' : 'Logout' }}
                    </button>
                </form>
            @else
                <a class="button" href="{{ route('home') }}#login" id="header-login-btn" data-open-login-modal-global
                   style="text-decoration:none">
                    {{ $isArabic ? 'دخول' : 'Login' }}
                </a>
            @endif
        </div>
    </div>
</header>
