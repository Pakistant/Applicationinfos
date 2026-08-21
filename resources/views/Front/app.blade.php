<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Actualités, analyses et tendances."><title>@yield('title', 'ActuInfos')</title>
  @include('Front.partials.style')
  @stack('styles')
</head>
<body><div class="site-shell">
  @include('Front.partials.header')
  <main class="page-wrap">
    @yield('Breaking_news') @yield('News_slider') @yield('Featured_news')
    <div class="content-grid"><section>@yield('Main_section')</section><aside class="sidebar">@include('Front.partials.sidebar')</aside></div>
  </main>
  @include('Front.partials.footer')
</div><a href="#" class="back-to-top" aria-label="Retour en haut"><i class="fa fa-arrow-up"></i></a>@include('Front.partials.scripts')
@stack('scripts')
</body>
</html>
