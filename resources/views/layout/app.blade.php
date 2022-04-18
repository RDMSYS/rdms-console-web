<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/assist.css') }}" />
    @yield('headers')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <title>@yield('title')</title>
  </head>
  <body id="body-pd" class="body-pd">
  {{-- <body id="body-pd" class="body-pd">
    <div class="info_msg_box">
      <span>
        Refreshed
      </span>
    </div> --}}
      


    <header class="header body-pd" id="header">
      <div class="header_toggle">
        <i class="bx bx-menu" id="header-toggle"></i>
      </div>
      <div class="header_img">
        <img src="https://i.imgur.com/hczKIze.jpg" alt="" />
      </div>
      
    </header>
    <div class="l-navbar show" id="nav-bar">
      <nav class="main_nav">
        <div>
          <a href="#" class="nav_logo">
            <i class="bx bx-desktop nav_logo-icon"></i>
            <span class="nav_logo-name">Console</span>
          </a>
          <div class="nav_list">
            <a href="#" class="nav_link active">
              <i class="bx bx-grid-alt nav_icon"></i>
              <span class="nav_name">Dashboard</span>
            </a>
            <a href="{{route('hostes.index')}}" class="nav_link ">
              <i class='bx bx-desktop nav_icon' style='color:#ffffff' ></i>
              <span class="nav_name">Devices</span>
            </a>
            
            
            
            
          </div>
        </div>
        <a href="#" class="nav_link">
          <i class="bx bx-log-out nav_icon"></i>
          <span class="nav_name">SignOut</span>
        </a>
      </nav>
    </div>
    <section class="main">
    @yield('body')
    </div>
    <div id="alert_holder"></div>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/ui.js') }}"></script>
    @yield('scripts')
  </body>
</html>
