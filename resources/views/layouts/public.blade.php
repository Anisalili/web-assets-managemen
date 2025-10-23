<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="@yield('meta_description', 'Web Assets Management System')" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--====== Title ======-->
    <title>@yield('title', config('app.name', 'Web Assets Management'))</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('templates/business/assets/images/favicon.svg') }}" type="image/svg" />

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('templates/business/assets/css/bootstrap.min.css') }}" />

    <!--====== Line Icons css ======-->
    <link rel="stylesheet" href="{{ asset('templates/business/assets/css/lineicons.css') }}" />

    <!--====== Tiny Slider css ======-->
    <link rel="stylesheet" href="{{ asset('templates/business/assets/css/tiny-slider.css') }}" />

    <!--====== gLightBox css ======-->
    <link rel="stylesheet" href="{{ asset('templates/business/assets/css/glightbox.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('templates/business/style.css') }}" />

    @stack('styles')
</head>

<body>

    @include('components.navbar')

    @include('components.sidebar')

    @yield('content')

    @include('components.footer')

    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!--====== js ======-->
    <script src="{{ asset('templates/business/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('templates/business/assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('templates/business/assets/js/main.js') }}"></script>
    <script src="{{ asset('templates/business/assets/js/tiny-slider.js') }}"></script>

    <script>
        //===== close navbar-collapse when a  clicked
        let navbarTogglerNine = document.querySelector(
            ".navbar-nine .navbar-toggler"
        );
        navbarTogglerNine.addEventListener("click", function() {
            navbarTogglerNine.classList.toggle("active");
        });

        // ==== left sidebar toggle
        let sidebarLeft = document.querySelector(".sidebar-left");
        let overlayLeft = document.querySelector(".overlay-left");
        let sidebarClose = document.querySelector(".sidebar-close .close");

        overlayLeft.addEventListener("click", function() {
            sidebarLeft.classList.toggle("open");
            overlayLeft.classList.toggle("open");
        });
        sidebarClose.addEventListener("click", function() {
            sidebarLeft.classList.remove("open");
            overlayLeft.classList.remove("open");
        });

        // ===== navbar nine sideMenu
        let sideMenuLeftNine = document.querySelector(".navbar-nine .menu-bar");

        sideMenuLeftNine.addEventListener("click", function() {
            sidebarLeft.classList.add("open");
            overlayLeft.classList.add("open");
        });

        //========= glightbox
        GLightbox({
            'href': 'https://www.youtube.com/watch?v=r44RKWyfcFw&fbclid=IwAR21beSJORalzmzokxDRcGfkZA1AtRTE__l5N4r09HcGS5Y6vOluyouM9EM',
            'type': 'video',
            'source': 'youtube', //vimeo, youtube or local
            'width': 900,
            'autoplayVideos': true,
        });
    </script>

    @stack('scripts')
</body>

</html>
