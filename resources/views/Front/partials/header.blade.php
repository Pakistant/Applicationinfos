@php
  $publicSettings = $global_setting ?? null;
  $publicSiteName = $publicSettings?->web_site_name ?: 'ActuInfos';
  $publicLogo = $publicSettings?->logo ? Storage::url($publicSettings->logo) : null;
  $publicCategories = ($global_categories ?? collect())->take(5);
  $publicSocials = ($global_social ?? collect())->take(4);
@endphp

<header class="site-header">
  <div class="header-inner client-masthead">
    <a href="{{ route('home') }}" class="client-brand" aria-label="Accueil {{ $publicSiteName }}">
      @if($publicLogo)
        <img src="{{ $publicLogo }}" alt="Logo {{ $publicSiteName }}" width="38" height="38">
      @else
        <span class="client-brand-mark"><i class="fas fa-landmark"></i></span>
      @endif
      <span class="client-brand-copy"><strong>{{ $publicSiteName }}</strong><small>L'actualité, les analyses et les idées</small></span>
    </a>

    <span class="client-tagline d-none d-md-block">L'actualité politique sous un angle clair</span>

    <div class="client-actions">
      @if($publicSocials->isNotEmpty())
        @foreach($publicSocials->take(3) as $social)
          <a class="client-icon-link d-none d-lg-grid" href="{{ $social->link }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social->name }}" title="{{ $social->name }}"><i class="{{ $social->icon }}"></i></a>
        @endforeach
      @endif
      @auth
        <a class="client-login-link" href="{{ route('dashboard') }}"><i class="fas fa-user-circle"></i><span class="d-none d-sm-inline">Espace pro</span></a>
      @else
        <a class="client-login-link" href="{{ route('login') }}"><i class="fas fa-user-circle"></i><span class="d-none d-sm-inline">Connexion</span></a>
      @endauth
      <button class="mobile-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false" onclick="const nav=document.querySelector('.main-nav'); const open=nav.classList.toggle('show'); this.setAttribute('aria-expanded', open ? 'true' : 'false');">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </div>

  <div class="client-nav-band">
    <nav class="main-nav header-inner" aria-label="Navigation principale">
      <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
      @foreach($publicCategories as $category)
        <a class="{{ request()->routeIs('category.article') && request()->route('slug') === $category->slug ? 'active' : '' }}" href="{{ route('category.article', $category->slug) }}">{{ $category->name }}</a>
      @endforeach
      <a class="{{ request()->routeIs('contact.front') ? 'active' : '' }}" href="{{ route('contact.front') }}">Contact</a>
      <form class="search-form" action="{{ route('search') }}" method="GET" role="search">
        <input type="search" name="search_key" value="{{ request('search_key') }}" placeholder="Rechercher" aria-label="Rechercher un article">
        <button type="submit" aria-label="Lancer la recherche"><i class="fas fa-search"></i></button>
      </form>
    </nav>
  </div>

  @if(($global_tags ?? collect())->isNotEmpty())
    <div class="trend-band">
      <div class="header-inner trend-inner">
        <span class="trend-label"><i class="fas fa-chart-line"></i> Tendances</span>
        @foreach(($global_tags ?? collect())->take(6) as $tag)
          <a href="{{ route('tag.articles', $tag->slug) }}">{{ $tag->name }}</a>
        @endforeach
      </div>
    </div>
  @endif
</header>

<style>
  .client-masthead { min-height:68px; justify-content:space-between; }
  .client-brand { display:flex; align-items:center; gap:10px; color:var(--ink)!important; }
  .client-brand img { object-fit:contain; }
  .client-brand-mark { width:38px; height:38px; display:grid; place-items:center; background:var(--accent); color:#fff; font-size:1.05rem; }
  .client-brand-copy { display:flex; flex-direction:column; line-height:1.1; }
  .client-brand-copy strong { font:800 1.35rem 'Playfair Display',serif; letter-spacing:-.04em; }
  .client-brand-copy small { color:var(--muted); font-size:.65rem; margin-top:4px; letter-spacing:.02em; }
  .client-tagline { border-left:1px solid var(--line); padding-left:18px; color:var(--muted); font-size:.78rem; margin-right:auto; margin-left:22px; }
  .client-actions { display:flex; align-items:center; gap:13px; }
  .client-icon-link { place-items:center; width:30px; height:30px; color:var(--muted); }
  .client-icon-link:hover { color:var(--brand); }
  .client-login-link { display:flex; align-items:center; gap:7px; color:var(--brand)!important; font-size:.82rem; font-weight:700; }
  .client-nav-band { background:#101827; }
  .client-nav-band .main-nav { min-height:50px; gap:0; }
  .client-nav-band .main-nav > a { color:#cad3e1; font-size:.76rem; letter-spacing:.09em; text-transform:uppercase; padding:16px 15px 14px; position:relative; }
  .client-nav-band .main-nav > a:first-child { padding-left:0; }
  .client-nav-band .main-nav > a.active, .client-nav-band .main-nav > a:hover { color:#fff; }
  .client-nav-band .main-nav > a.active:after { content:''; position:absolute; bottom:0; left:15px; right:15px; height:3px; background:var(--accent); }
  .client-nav-band .main-nav > a:first-child.active:after { left:0; }
  .client-nav-band .search-form { margin-left:auto; width:210px; border:1px solid #344258; background:#182235; }
  .client-nav-band .search-form input { color:#fff; }
  .client-nav-band .search-form input::placeholder { color:#9aa7bb; }
  .client-nav-band .search-form button { background:var(--accent); }
  .trend-band { background:#f0ede7; border-bottom:1px solid #e1ddd5; }
  .trend-inner { min-height:38px; display:flex; align-items:center; gap:23px; overflow:hidden; white-space:nowrap; }
  .trend-label { color:var(--accent); font-size:.72rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; }
  .trend-label i { margin-right:5px; }
  .trend-inner a { color:#475467; font-size:.78rem; }
  .trend-inner a:hover { color:var(--brand); }
  @media(max-width:991px) { .client-tagline { display:none; }.client-nav-band .main-nav { display:none; position:absolute; top:68px; left:0; right:0; z-index:101; min-height:auto; padding:12px 20px 18px; flex-direction:column; align-items:stretch; background:#101827; }.client-nav-band .main-nav.show { display:flex; }.client-nav-band .main-nav > a,.client-nav-band .main-nav > a:first-child { padding:12px 0; }.client-nav-band .main-nav > a.active:after { left:0; right:auto; width:34px; }.client-nav-band .search-form { width:100%; margin:10px 0 0; }.mobile-toggle { display:block; margin-left:0; } }
  @media(max-width:600px) { .client-masthead { min-height:62px; }.client-brand-copy strong { font-size:1.12rem; }.client-brand-copy small { display:none; }.trend-inner { gap:14px; padding-left:20px; }.trend-inner a:nth-of-type(n+4) { display:none; } }
</style>
