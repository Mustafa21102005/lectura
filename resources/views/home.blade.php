@extends('layouts.website')

@section('title', 'Home')

@section('content')
    {{-- Main Banner --}}
    <div class="main-banner" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel owl-banner">

                        {{-- Slide 1 --}}
                        <div class="item item-1">
                            <div class="header-text">
                                <span class="category">Welcome to Lectura</span>
                                <h2>Your Digital School, Anytime & Anywhere</h2>
                                <p>
                                    Lectura is a modern virtual learning environment that connects students, teachers,
                                    parents, and administrators in one powerful platform for education and growth.
                                </p>
                            </div>
                        </div>

                        {{-- Slide 2 --}}
                        <div class="item item-2">
                            <div class="header-text">
                                <span class="category">For Students, Teachers & Parents</span>
                                <h2>Learning & Monitoring Made Simple</h2>
                                <p>
                                    From interactive classes to assignment submissions and tracking, Lectura makes school
                                    life easier and more organized for students, teachers, and parents alike.
                                </p>
                            </div>
                        </div>

                        {{-- Slide 3 --}}
                        <div class="item item-3">
                            <div class="header-text">
                                <span class="category">Smart Schooling</span>
                                <h2>Education Beyond the Classroom</h2>
                                <p>
                                    With Lectura, your school community stays connected. Access subjects, assignments, and
                                    resources anytime — wherever you are.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Services --}}
    <div class="services section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('website/assets/images/service-01.png') }}" alt="digital learning">
                        </div>
                        <div class="main-content">
                            <h4>Digital Learning</h4>
                            <p>Access your cirriculums, subjects, and study materials anytime, all in one place.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('website/assets/images/service-02.png') }}" alt="assignments & grades">
                        </div>
                        <div class="main-content">
                            <h4>Assignments & &nbsp;&nbsp;&nbsp; Grades</h4>
                            <p>Stay on top of your progress with easy access to assignments, submissions, and results.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="{{ asset('website/assets/images/service-03.png') }}" alt="collaboration">
                        </div>
                        <div class="main-content">
                            <h4>Collaboration & Feedback</h4>
                            <p>Receive feedback from teachers, with updates visible to both students and parents.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- About Us --}}
    <div class="section about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-1">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How does Lectura help students and parents?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lectura makes learning easier by giving students a single place to access subjects,
                                    assignments, and grades — anytime and anywhere. Parents can also track their children's
                                    progress and stay updated on assignments and results.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How do teachers, students, and parents connect?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lectura builds stronger communication between teachers, students, and parents.
                                    Teachers can share resources and feedback, students can collaborate,
                                    and parents can monitor and support their children's learning with ease.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Why choose Lectura over others?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Lectura is built with simplicity and students in mind. It combines digital learning,
                                    assignment tracking, collaboration tools, and parent monitoring — all without
                                    unnecessary complexity.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Do we get support when needed?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Absolutely. Lectura offers continuous updates and support to make sure students,
                                    teachers, and parents can focus on learning instead of dealing with technical issues.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 align-self-center">
                    <div class="section-heading">
                        <h6>About Us</h6>
                        <h2>Why Lectura is the future of learning</h2>
                        <p>Lectura is designed to bring students, teachers, and parents together in one digital space.
                            From managing courses to tracking progress, we make education accessible and effective
                            for everyone.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section courses" id="curriculums">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Curriculums</h6>
                        <h2>Subjects by Curriculum</h2>
                    </div>
                </div>
            </div>

            {{-- Filter buttons --}}
            <ul class="event_filter">
                <li><a class="is_active" href="#!" data-filter="*">Show All</a></li>
                @foreach ($curriculums as $curriculum)
                    <li>
                        <a href="#!" data-filter=".curriculum-{{ $curriculum->id }}">
                            {{ $curriculum->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- Subjects grid --}}
            <div class="row event_box">
                @foreach ($subjects as $subject)
                    <div class="col-lg-4 col-md-6 mb-30 event_outer {{ $subject->filter_classes }}">
                        <div class="events_item">
                            <div class="down-content">
                                <h4>{{ $subject->name }}</h4>

                                <div>
                                    @if (!empty($subject->grade_display))
                                        <span class="badge bg-primary m-1">
                                            Grades {{ $subject->grade_display }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary m-1">
                                            No grades assigned
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="section fun-facts">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="1750" data-speed="1000"></h2>
                                    <p class="count-text ">Happy Students</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="14500" data-speed="1000"></h2>
                                    <p class="count-text ">Alumni</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="160" data-speed="1000"></h2>
                                    <p class="count-text ">Staff</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter end">
                                    <h2 class="timer count-title count-number" data-to="11" data-speed="1000"></h2>
                                    <p class="count-text ">Years Experience</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Display a listing of teachers --}}
    <div class="team section" id="team">
        <div class="container">
            <div class="row">
                @foreach ($teachers as $teacher)
                    <div class="col-lg-3 col-md-6">
                        <div class="team-member">
                            <div class="main-content text-center">
                                <img src="{{ Avatar::create($teacher->name)->setDimension(400, 400)->setFontSize(200)->toBase64() }}"
                                    alt="Profile" width="200" height="220">

                                <h4>{{ $teacher->name }}</h4>

                                <div>
                                    {{-- Show first subjects --}}
                                    @foreach ($teacher->firstSubjects as $assignment)
                                        <span class="badge bg-primary m-1">
                                            {{ $assignment }}
                                        </span>
                                    @endforeach

                                    {{-- Hidden subjects --}}
                                    @if (count($teacher->extraSubjects) > 0)
                                        <span class="extra-subjects" style="display:none;">
                                            @foreach ($teacher->extraSubjects as $assignment)
                                                <span class="badge bg-secondary m-1">
                                                    {{ $assignment }}
                                                </span>
                                            @endforeach
                                        </span>

                                        <button type="button" class="btn btn-link p-0 show-more-btn">
                                            + Show more
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            $(document).on('click', '.show-more-btn', function() {
                const $btn = $(this);
                const $extra = $btn.prev('.extra-subjects');

                $extra.stop(true, true).fadeToggle(200);
                $btn.text(
                    $extra.is(':visible') ? '- Show less' : '+ Show more'
                );
            });
        });
    </script>
@endsection
