<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Lectura is a digital school connecting students, teachers, and parents, offering study materials, assignments, and collaboration tools.">
    <meta name="keywords"
        content="Lectura, e-learning, virtual school, online courses, digital learning, students, teachers, parents">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('dashboard/assets/img/favicon/favicon-96x96.png') }}"
        sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('dashboard/assets/img/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/img/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('dashboard/assets/img/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('dashboard/assets/img/favicon/site.webmanifest') }}" />

    <title>Lectura | @yield('title')</title>

    {{-- Bootstrap core CSS --}}
    <link href="{{ asset('website/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    {{-- Additional CSS Files --}}
    <link rel="stylesheet" href="{{ asset('website/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/templatemo-scholar.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/animate.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    @yield('css')
    {{-- TemplateMo 586 Scholar https://templatemo.com/tm-586-scholar --}}
</head>

<body>
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a href="{{ route('home') }}" class="logo">
                            <h1>Lectura</h1>
                        </a>
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="#services">Services</a></li>
                            <li class="scroll-to-section"><a href="#curriculums">Curriculums</a></li>
                            <li class="scroll-to-section"><a href="#team">Teachers</a></li>
                            <li>
                                @auth
                                    <a href="{{ route('dashboard') }}">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}">
                                        Log in
                                    </a>
                                @endauth
                            </li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer>
        <div class="container">
            <div class="col-lg-12">
                <div class="row align-items-center">
                    {{-- Copyright --}}
                    <div class="col-md-12 text-center text-md-start mb-2 mb-md-0">
                        <p class="mb-0">&copy; 2025 Lectura. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="{{ asset('website/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('website/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('website/assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('website/assets/js/counter.js') }}"></script>
    <script src="{{ asset('website/assets/js/custom.js') }}"></script>

    @yield('js')
</body>

</html>
