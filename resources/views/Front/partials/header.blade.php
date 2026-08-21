<header class="site-header"><div class="header-inner">
  <a href="{{ route('home') }}" class="brand"><span class="brand-mark">Actu</span>Infos<span class="brand-dot">.</span></a>
  <button class="mobile-toggle" type="button" aria-label="Ouvrir le menu" onclick="document.querySelector('.main-nav').classList.toggle('show')"><i class="fas fa-bars"></i></button>
  <nav class="main-nav">
    <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
    @foreach($global_categories->take(3) as $category)<a href="{{ route('category.article', $category->slug) }}">{{ $category->name }}</a>@endforeach
    <a class="{{ request()->routeIs('contact.front') ? 'active' : '' }}" href="{{ route('contact.front') }}">Contact</a>
    @auth <a href="{{ route('dashboard') }}">Espace pro</a> @else <a href="{{ route('login') }}">Connexion</a> @endauth
    <form class="search-form" action="{{ route('search') }}" method="POST">@csrf<input type="search" name="search_key" placeholder="Rechercher" aria-label="Rechercher"><button type="submit" aria-label="Lancer la recherche"><i class="fa fa-search"></i></button></form>
  </nav>
</div></header>
