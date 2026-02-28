{{--
* Material Dashboard 2 - v3.0.0

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Quicksand:wght@300..700&display=swap"
        rel="stylesheet">

    {{-- Nucleo Icons --}}
    <link href="{{ asset('dashboard/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.dataTables.min.css">

    {{-- CSS Files --}}
    <link id="pagestyle" href="{{ asset('dashboard/assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />

    <style>
        /* Hide the broken square glyph */
        .dropdown-toggle::after {
            display: none !important;
        }

        /* Smooth rotation animation */
        .dropdown-caret {
            transition: transform 0.3s ease !important;
        }

        /* Rotate 180deg when dropdown is shown */
        .dropdown.show .dropdown-toggle .dropdown-caret {
            transform: rotate(180deg) !important;
        }

        * {
            font-family: "Quicksand", sans-serif;
        }

        /* Gradient animation */
        @keyframes AnimationName {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animated-bg {
            border-radius: 10px;
            background: linear-gradient(270deg, #ce68d9, #45c6db, #45db79, #9f45b0, #e54ed0, #ffe4f2);
            background-size: 800% 800%;
            animation: AnimationName 10s ease-in-out infinite;
        }

        .animated-bg:hover {
            animation-play-state: paused;
        }

        #sidenav-collapse-main {
            height: 100%;
            /* take full height of parent */
        }
    </style>

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @yield('css')
</head>

<body class="g-sidenav-show  bg-gray-200">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" style="font-size: 1.3rem; font-family: cursive;"
                href="{{ route('dashboard') }}">
                <img src="{{ asset('dashboard/assets/img/favicon/favicon-96x96.png') }}"
                    class="navbar-brand-img h-100 me-2" alt="main_logo"
                    style="filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.2)); width: 40px; height: 40px; border-radius: 50%;">
                <span class="ms-1 font-weight-bold text-white">Lectura</span>
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">home</i>
                        </div>
                        <span class="nav-link-text ms-1">Home</span>
                    </a>
                </li>
                @role('teacher|parent')
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('user') ? 'active' : '' }}"
                            href="{{ route('user', ['id' => Auth::id()]) }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">chat</i>
                            </div>
                            <span class="nav-link-text ms-1">Chat</span>
                        </a>
                    </li>
                @endrole
                <li class="nav-item">
                    <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                @role('admin')
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('curriculums.index') ? 'active' : '' }}"
                            href="{{ route('curriculums.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">book</i>
                            </div>
                            <span class="nav-link-text ms-1">Curriculums</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('subjects.index') ? 'active' : '' }}"
                            href="{{ route('subjects.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">auto_stories</i>
                            </div>
                            <span class="nav-link-text ms-1">Subjects</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('users.index') ? 'active' : '' }}"
                            href="{{ route('users.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">person</i>
                            </div>
                            <span class="nav-link-text ms-1">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('grade-levels.index') ? 'active' : '' }}"
                            href="{{ route('grade-levels.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">school</i>
                            </div>
                            <span class="nav-link-text ms-1">Grade Levels</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('sections.index') ? 'active' : '' }}"
                            href="{{ route('sections.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">category</i>
                            </div>
                            <span class="nav-link-text ms-1">Sections</span>
                        </a>
                    </li>
                @endrole
                @role('teacher')
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('assignments.index') ? 'active' : '' }}"
                            href="{{ route('assignments.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">assignment</i>
                            </div>
                            <span class="nav-link-text ms-1">Assignments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('grades.index') ? 'active' : '' }}"
                            href="{{ route('grades.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">military_tech</i>
                            </div>
                            <span class="nav-link-text ms-1">Grades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('teacher.subjects.index') ? 'active' : '' }}"
                            href="{{ route('teacher.subjects.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">auto_stories</i>
                            </div>
                            <span class="nav-link-text ms-1">My Subjects</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('material-types.index') ? 'active' : '' }}"
                            href="{{ route('material-types.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">category</i>
                            </div>
                            <span class="nav-link-text ms-1">Material Types</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('study-materials.index') ? 'active' : '' }}"
                            href="{{ route('study-materials.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">menu_book</i>
                            </div>
                            <span class="nav-link-text ms-1">Study Materials</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('submissions.index') ? 'active' : '' }}"
                            href="{{ route('submissions.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">upload_file</i>
                            </div>
                            <span class="nav-link-text ms-1">Submissions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('teacher.students.index') ? 'active' : '' }}"
                            href="{{ route('teacher.students.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">group</i>
                            </div>
                            <span class="nav-link-text ms-1">My Students</span>
                        </a>
                    </li>
                @endrole
                @role('student')
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('student.assignments.index') ? 'active' : '' }}"
                            href="{{ route('student.assignments.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">assignment</i>
                            </div>
                            <span class="nav-link-text ms-1">My Assignments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('student.info') ? 'active' : '' }}"
                            href="{{ route('student.info') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">manage_accounts</i>
                            </div>
                            <span class="nav-link-text ms-1">My Info</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('student.subjects.index') ? 'active' : '' }}"
                            href="{{ route('student.subjects.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">auto_stories</i>
                            </div>
                            <span class="nav-link-text ms-1">My Subjects</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('student.submissions.index') ? 'active' : '' }}"
                            href="{{ route('student.submissions.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">upload_file</i>
                            </div>
                            <span class="nav-link-text ms-1">My Submissions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('student.study-materials.index') ? 'active' : '' }}"
                            href="{{ route('student.study-materials.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">menu_book</i>
                            </div>
                            <span class="nav-link-text ms-1">My Study Materials</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('student.grades.index') ? 'active' : '' }}"
                            href="{{ route('student.grades.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">military_tech</i>
                            </div>
                            <span class="nav-link-text ms-1">My Grades</span>
                        </a>
                    </li>
                @endrole
                @role('parent')
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('parent.users.index') ? 'active' : '' }}"
                            href="{{ route('parent.users.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">family_restroom</i>
                            </div>
                            <span class="nav-link-text ms-1">My Children</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('parent.assignments.index') ? 'active' : '' }}"
                            href="{{ route('parent.assignments.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">assignment</i>
                            </div>
                            <span class="nav-link-text ms-1">Child Assignments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('parent.grades.index') ? 'active' : '' }}"
                            href="{{ route('parent.grades.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">military_tech</i>
                            </div>
                            <span class="nav-link-text ms-1">Child Grades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('parent.study-materials.index') ? 'active' : '' }}"
                            href="{{ route('parent.study-materials.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">menu_book</i>
                            </div>
                            <span class="nav-link-text ms-1">Child Study Materials</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white gradient-shuffle {{ request()->routeIs('parent.submissions.index') ? 'active' : '' }}"
                            href="{{ route('parent.submissions.index') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">upload_file</i>
                            </div>
                            <span class="nav-link-text ms-1">Child Submissions</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </div>
    </aside>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <h4 class="font-weight-bolder mb-0">@yield('page_header')</h4>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <ul class="navbar-nav ms-auto justify-content-end">
                        <li class="nav-item dropdown d-flex align-items-center">
                            <a href="#"
                                class="nav-link text-body font-weight-bold px-0 dropdown-toggle d-flex align-items-center"
                                id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="Profile"
                                    class="rounded-circle me-2" width="35" height="35">
                                <span class="d-sm-inline d-none me-1">{{ Auth::user()->name }}</span>
                                <i class="material-icons dropdown-caret">expand_more</i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end px-2 shadow" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('profile.edit') }}">
                                        <i class="material-icons-round me-2 my-auto">person</i>
                                        <span class="my-auto">Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}"
                                        class="d-flex align-items-center">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item text-danger d-flex align-items-center">
                                            <i class="material-icons-round me-2 my-auto">logout</i>
                                            <span class="my-auto">Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid py-4">

            @yield('content')

            <footer class="footer py-4">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            &copy; 2025 Lectura. All rights reserved.
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
    <script src="{{ asset('dashboard/assets/js/plugins/chartjs.min.js') }}"></script>

    <script>
        const colors = [
            'bg-gradient-primary',
            'bg-gradient-secondary',
            'bg-gradient-success',
            'bg-gradient-info',
            'bg-gradient-warning',
            'bg-gradient-danger'
        ];

        function getRandomGradient() {
            return colors[Math.floor(Math.random() * colors.length)];
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.gradient-shuffle').forEach(link => {
                const route = link.getAttribute('href');

                if (link.classList.contains('active')) {
                    const savedGradient = localStorage.getItem('nav-gradient-' + route) ||
                        getRandomGradient();
                    colors.forEach(c => link.classList.remove(c));
                    link.classList.add(savedGradient);
                    localStorage.setItem('nav-gradient-' + route, savedGradient);
                } else {
                    colors.forEach(c => link.classList.remove(c));
                }
            });
        });

        document.querySelectorAll('.gradient-shuffle').forEach(link => {
            link.addEventListener('click', function(e) {
                const randomGradient = getRandomGradient();

                // Remove active & gradients instantly from all links
                document.querySelectorAll('.gradient-shuffle').forEach(l => {
                    l.classList.remove('active');
                    colors.forEach(c => l.classList.remove(c));
                });

                // Add active & gradient to clicked link
                link.classList.add('active');
                link.classList.add(randomGradient);

                // Save the gradient
                const route = link.getAttribute('href');
                localStorage.setItem('nav-gradient-' + route, randomGradient);

                // Navigate
                window.location.href = link.href;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('.nav-item.dropdown');

            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const caret = toggle.querySelector('.dropdown-caret');

                dropdown.addEventListener('show.bs.dropdown', () => {
                    caret.style.transform = 'rotate(180deg)';
                });
                dropdown.addEventListener('hide.bs.dropdown', () => {
                    caret.style.transform = 'rotate(0deg)';
                });
            });
        });
    </script>

    {{-- Success Toast --}}
    <script>
        window.addEventListener('success-toast', event => {
            const toast = document.getElementById('successToast');
            if (!toast) return;

            toast.querySelector('.toast-body').textContent = event.detail.message;
            toast.style.opacity = 1;

            setTimeout(() => {
                toast.style.opacity = 0;
            }, 4000);

            setTimeout(() => {
                // optional: remove or hide completely
                toast.style.opacity = 0;
            }, 4500);
        });
    </script>

    {{-- Error Toast --}}
    <script>
        window.addEventListener('error-toast', event => {
            const toast = document.getElementById('dangerToast');
            if (!toast) return;

            toast.querySelector('.toast-body').textContent = event.detail.message;
            toast.style.opacity = 1;

            setTimeout(() => {
                toast.style.opacity = 0;
            }, 4000);

            setTimeout(() => {
                // optional: remove or hide completely
                toast.style.opacity = 0;
            }, 4500);
        });
    </script>

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

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/3.0.7/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('js')
</body>

</html>
