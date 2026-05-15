<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- Favicon -->
    <link href="{{ asset('front_user/img/favicon.ico')}}" rel="icon" />
    


    @include('Front.partials.style')
  </head>

  <body>
    <!-- Debut Topbar -->
    @include('Front.partials.top_bar')
    <!-- Topbar fin -->

    <!-- Navbar debut -->
    @include('Front.partials.header')
    <!-- Navbar fin -->

    <br />
    <!-- Breaking News Start -->
      @yield('Breaking_news')
    <!-- Breaking News End -->
     
    <!-- Main News Slider Debut -->
      @yield('News_slider')
    <!-- News Slider fin -->

    <!-- Featured News Slider debut -->
      @yield('Featured_news')
    <!-- Featured News Slider fin -->
      
    <!-- News With Sidebar debut -->
    <div class="container-fluid">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
          @yield('Main_section')

          </div>
        <!-- debut sidebar-->

        @include('Front.partials.sidebar')
        <!-- fin  Sidebar -->
         
        </div>
      </div>
    </div> 
    <!-- News With Sidebar fin -->

    <!-- Footer debut -->
    @include('Front.partials.footer')
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-info btn-square back-to-top"
      ><i class="fa fa-arrow-up"></i   ></a>

   @include('Front.partials.scripts')
  </body>
</html>
