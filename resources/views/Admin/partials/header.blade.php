@php
  $adminUser = Auth::user();
  $siteSettings = $global_setting ?? null;
  $siteName = $siteSettings?->web_site_name ?: 'Actupolitique';
  $siteLogo = $siteSettings?->logo ? Storage::url($siteSettings->logo) : asset('back_auth/assets/img/logo.png');
  $userImage = $adminUser->image ? asset('back_auth/assets/Profile/'.$adminUser->image) : asset('back_auth/assets/img/user.jpg');
  $isAdminUser = in_array('admin', explode(',', $adminUser->role), true);
@endphp

<style>
  .admin-brand-meta { display: inline-flex; flex-direction: column; vertical-align: middle; line-height: 1.15; }
  .admin-brand-name { font-weight: 700; color: #1f2937; }
  .admin-brand-label { color: #8a8f98; font-size: 10px; text-transform: uppercase; letter-spacing: .08em; }
  .admin-user-role { font-size: 11px; }
  .admin-search-form { position: relative; }
  .admin-search-form .form-control { padding-right: 42px; min-width: 230px; }
  .admin-search-form .btn { position: absolute; right: 0; top: 0; height: 100%; color: #6c757d; }
  @media (max-width: 767px) { .admin-search-form .form-control { min-width: 0; width: 170px; } }
</style>

<div class="header">
  <div class="header-left">
    <a href="{{ route('dashboard') }}" class="logo" aria-label="Retour au tableau de bord">
      <img src="{{ $siteLogo }}" width="42" height="42" alt="Logo {{ $siteName }}" style="object-fit:contain;">
      <span class="admin-brand-meta ml-2">
        <span class="admin-brand-name">{{ $siteName }}</span>
        <span class="admin-brand-label">Back-office</span>
      </span>
    </a>
    <a href="{{ route('dashboard') }}" class="logo logo-small" aria-label="Tableau de bord">
      <img src="{{ $siteLogo }}" alt="{{ $siteName }}" width="32" height="32" style="object-fit:contain;">
    </a>
  </div>

  <a href="javascript:void(0);" id="toggle_btn" aria-label="Réduire le menu">
    <i class="fe fe-text-align-left"></i>
  </a>
  <a class="mobile_btn" id="mobile_btn" aria-label="Ouvrir le menu"><i class="fas fa-bars"></i></a>

  <div class="top-nav-search">
    <form class="admin-search-form" action="{{ route('search') }}" method="GET">
      <input type="search" class="form-control" name="search_key" value="{{ request('search_key') }}" placeholder="Rechercher un article" aria-label="Rechercher un article">
      <button class="btn" type="submit" aria-label="Lancer la recherche"><i class="fas fa-search"></i></button>
    </form>
  </div>

  <ul class="nav user-menu">
    <li class="nav-item mr-3 d-none d-md-block">
      <a class="nav-link" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" title="Voir le site public">
        <i class="fas fa-external-link-alt mr-1"></i> Voir le site
      </a>
    </li>
    <li class="nav-item dropdown has-arrow">
      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
        <span class="user-img"><img class="rounded-circle" src="{{ $userImage }}" width="34" height="34" alt="{{ $adminUser->name }}" style="object-fit:cover;"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="user-header">
          <div class="avatar avatar-sm"><img src="{{ $userImage }}" alt="{{ $adminUser->name }}" class="avatar-img rounded-circle" style="object-fit:cover;"></div>
          <div class="user-text">
            <h6>{{ $adminUser->name }}</h6>
            <p class="text-muted mb-0 admin-user-role">{{ $isAdminUser ? 'Administrateur' : 'Auteur' }}</p>
          </div>
        </div>
        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user mr-2 text-muted"></i>Mon profil</a>
        @if($isAdminUser)
          <a class="dropdown-item" href="{{ route('setting.index') }}"><i class="fas fa-cog mr-2 text-muted"></i>Paramètres du site</a>
        @endif
        <div class="dropdown-divider"></div>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt mr-2 text-muted"></i>Déconnexion</button>
        </form>
      </div>
    </li>
  </ul>
</div>
