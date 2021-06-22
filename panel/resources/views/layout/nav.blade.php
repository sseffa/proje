<nav id="js-primary-nav" class="primary-nav" role="navigation">
    <div class="nav-filter">
        <div class="position-relative">
            <input type="text" id="nav_filter_input" placeholder="Menüyü Filtrele" class="form-control" tabindex="0">
            <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle"
               data-class="list-filter-active" data-target=".page-sidebar">
                <i class="fal fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <div class="info-card">
        <img src="{{ gravatarUrl(auth()->user()->email) }}" class="profile-image rounded-circle"
             alt="Dr. Codex Lantern">
        <div class="info-card-text">
            <a href="#" class="d-flex align-items-center text-white">
                                    <span class="text-truncate text-truncate-sm d-inline-block">
                                        {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                                    </span>
            </a>
            <span
                class="d-inline-block text-truncate text-truncate-sm">{{ auth()->user()->type === 'user' ? 'Öğrenci' : 'Eğitmen' }}</span>
        </div>
        <img src="/assets/img/card-backgrounds/cover-2-lg.png" class="cover" alt="cover">
        <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle"
           data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
            <i class="fal fa-angle-down"></i>
        </a>
    </div>
    <ul id="js-nav-menu" class="nav-menu">

        <li>
            <a href="{{ route('home') }}" title="Ana Sayfa" data-filter-tags="Ana Sayfa">
                <i class="fal fa-home"></i>
                <span class="nav-link-text" data-i18n="Ana Sayfa">Ana Sayfa</span>
            </a>
        </li>

        @if(auth()->user()->type !== 'user')
            <li class="nav-title">İşlemler</li>

            <li class="open">
                <a href="{{ route('teams.create') }}" title="Ekip Oluştur" data-filter-tags="Ekip Oluştur">
                    <i class="fal fa-plus"></i>
                    <span class="nav-link-text" data-i18n="Ekip Oluştur">Ekip Oluştur</span>
                </a>
            </li>
        @endif

        <li class="nav-title">Ekipler</li>

        @foreach($teams as $team)
            <li>
                <a href="{{ route('activities.show', ['team'=>$team->id]) }}" title="{{ $team->name }}"
                   data-filter-tags="{{ $team->name }}">
                    <i class="fal fa-users"></i>
                    <span class="nav-link-text" data-i18n="nav.{{ $team->name }}">{{ $team->name }}</span>
                </a>
            </li>
        @endforeach

        @foreach($joinedTeams as $team)
            <li>
                <a href="{{ route('activities.show', ['team'=>$team->id]) }}" title="{{ $team->name }}"
                   data-filter-tags="{{ $team->name }}">
                    <i class="fal fa-users"></i>
                    <span class="nav-link-text" data-i18n="nav.{{ $team->name }}">{{ $team->name }}</span>
                </a>
            </li>
        @endforeach

        @if(auth()->user()->type !== 'instructor')
            <li class="nav-title">Ekibe Katıl</li>
            <li>
                <a href="#" title="Pages" data-filter-tags="pages" data-toggle="modal" data-target="#join-team">
                    <i class="fal fa-plus-circle"></i>
                    <span class="nav-link-text" data-i18n="nav.pages">Katıl</span>
                </a>
            </li>
        @endif
    </ul>
    <div class="filter-message js-filter-message bg-success-600"></div>
</nav>
