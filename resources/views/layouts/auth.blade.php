{{--
* Material Dashboard 2 - v3.0.0

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
Software.
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('dashboard/assets/img/favicon/favicon-96x96.png') }}"
        sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('dashboard/assets/img/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/img/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('dashboard/assets/img/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('dashboard/assets/img/favicon/site.webmanifest') }}" />

    <title>
        Lectura | @yield('title')
    </title>

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fonts and icons --}}
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    {{-- Nucleo Icons --}}
    <link href="{{ asset('dashboard/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    {{-- CSS Files --}}
    <link id="pagestyle" href="{{ asset('dashboard/assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />

    @yield('css')
</head>

<body class="bg-gray-200">

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-4"></span>

            @yield('content')

            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                &copy; 2025 Lectura.
                                Made by
                                <a href="https://www.creative-tim.com" class="font-weight-bold text-white"
                                    target="_blank">
                                    Creative Tim
                                </a>
                                for a better web.
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="nav-link text-white">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('home') }}#services" class="nav-link text-white">
                                        Services
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('home') }}#cirriculums" class="nav-link text-white">
                                        Cirriculums
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('home') }}#team" class="nav-link text-white">
                                        Team
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>

    {{-- Success Toast --}}
    <x-success-toast />

    {{-- Error Toast --}}
    <x-error-toast />

    {{-- Core JS Files --}}
    <script src="{{ asset('dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    {{-- Github buttons --}}
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    {{-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc --}}
    <script src="{{ asset('dashboard/assets/js/material-dashboard.min.js?v=3.0.0') }}"></script>

    <script>
        window.addEventListener('load', function() {
            const inputs = document.querySelectorAll('.form-control');
            for (const input of inputs) {
                if (input.value && input.value.trim() !== '') {
                    input.focus();
                }
            }
        });
    </script>

    @yield('js')
</body>

</html>
