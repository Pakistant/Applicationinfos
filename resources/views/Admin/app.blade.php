<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=0"
    />
    <title>@yield('title')</title>
    {{-- Dashboard - Links --}}
     @include('Admin.partials.styles')
    {{-- Fin Dashboard Link --}}
  </head>

  <body>
    <body>
    <!-- Loader -->
    <div id="loader" style="
        position: fixed; 
        top: 0;
        left: 0;
        width: 100%; 
        height: 100%; 
        background: #fff; 
        z-index: 9999; 
        display: flex; 
        align-items: center; 
        justify-content: center;">
        <div class="spinner"></div>
    </div>

    <style>
        .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    {{-- Main wrapper --}}
    <div class="main-wrapper">
      {{-- Debut Header --}}
      @include('Admin.partials.header')
      {{-- Fin Header --}}
        
      {{-- Debut Sidebar --}}
      @include('Admin.partials.sidebar')
      {{-- Fin Sidebar --}}
      {{-- --------------------- --}}
      {{-- Contenu de la page --}}
      <div class="page-wrapper">
        <div class="content container-fluid">

         <div class="page-header">

            @yield('dashboard-header')

        </div>
          @yield('dashboard-content')
        </div>
      </div>
      {{-- Fin Contenu de la page --}}
    </div>
    {{-- Scripts dashboard --}}
    
     @include('Admin.partials.scripts')
    {{-- Fin Script Dashboard --}}

    @if (session('success'))
      <script>
        iziToast.success({
          title: 'Succès',
          message: '{{ session('success') }}',
          position: 'topRight'
        });
      </script>
    @endif
    @if (session('error'))
      <script>
        iziToast.error({
          title: 'Erreur',
          message: '{{ session('error') }}',
          position: 'topRight'
        });
      </script>
    @endif
    
  </body>
</html>
