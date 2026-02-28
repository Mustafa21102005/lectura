@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page_header', 'Dashboard')

@section('content')
    <div class="row">
        @role('admin')
            {{-- Total Teachers --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Teachers</p>
                            <h4 class="mb-0">{{ $totalTeachers }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Student --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Students</p>
                            <h4 class="mb-0">{{ $totalStudentsAdmin }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Parents --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Parents</p>
                            <h4 class="mb-0">{{ $totalParents }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Assignments --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">assignment</i>
                        </div>

                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Assignments</p>
                            <h4 class="mb-0">{{ $totalAssignmentsAdmin }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3"></div>
                </div>
            </div>
        @endrole

        @role('teacher')
            {{-- Total Students that the teacher is Teaching --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Students</p>
                            <h4 class="mb-0">{{ $totalStudents }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Subjects that the teacher is teaching --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">book</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Subjects</p>
                            <h4 class="mb-0">{{ $totalSubjects }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Ungraded Submissions --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">assignment_late</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Ungraded Submissions</p>
                            <h4 class="mb-0">{{ $totalUngraded }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Assignments --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">assignment</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Assignments</p>
                            <h4 class="mb-0">{{ $totalAssignmentsTeacher }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3"></div>
                </div>
            </div>
        @endrole

        @role('student')
            {{-- Amount of Assignment that needs to be submitted --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">assignment_late</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Pending Assignments</p>
                            <h4 class="mb-0">{{ $pendingAssignments }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Subjects for the student --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">book</i>
                        </div>

                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Subjects</p>
                            <h4 class="mb-0">{{ $totalStudentSubjects }}</h4>
                        </div>
                    </div>

                    <div class="card-footer p-3"></div>
                </div>
            </div>

            {{-- Average Grade --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">grade</i>
                        </div>

                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Average Grade</p>
                            <h4 class="mb-0">{{ $averageGrade }}</h4>
                        </div>
                    </div>

                    <div class="card-footer p-3"></div>
                </div>
            </div>

            {{-- Total Submissions / Total Assignments --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">assignment_turned_in</i>
                        </div>

                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Submitted Assignments</p>
                            <h4 class="mb-0 {{ $isLowSubmission ? 'text-danger' : '' }}">
                                {{ $submittedAssignments }} / {{ $totalStudentAssignments }}
                            </h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>
        @endrole

        @role('parent')
            {{-- Total Children --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">family_restroom</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Children</p>
                            <h4 class="mb-0">{{ $childrenCount }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Pending Assignments for all children --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">assignment_late</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Total Pending Assignments</p>
                            <h4 class="mb-0">{{ $pendingAssignmentsCount }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Graded Assignments for all children --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">check_circle</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Graded Assignments</p>
                            <h4 class="mb-0">{{ $gradedAssignmentsCount }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>

            {{-- Total Late Assignments for all children --}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">alarm</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Late Submissions</p>
                            <h4 class="mb-0">{{ $lateSubmissionsCount }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div>
        @endrole
    </div>

    <div class="row mt-4">
        @role('admin')
            {{-- Number of students per grade level --}}
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2 ">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Enrollment by Grade Level</h6>
                        <p class="text-sm">Number of students per grade</p>
                    </div>
                </div>
            </div>

            {{-- Assignment submissions for the past week --}}
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2  ">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Assignments Submitted</h6>
                        <p class="text-sm">Daily submissions for the past week.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-4 mb-3">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="graded-ungraded-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Graded vs Ungraded Assignments</h6>
                        <p class="text-sm">Overview of assignment evaluation</p>
                    </div>
                </div>
            </div>
        @endrole

        @role('teacher')
            {{-- All Submissions Satatuses --}}
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="status-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Submissions Status Overview</h6>
                        <p class="text-sm">Submitted vs Late vs Graded</p>
                    </div>
                </div>
            </div>

            {{-- Top 3 students with the best grades --}}
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="top-students-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Top 3 Students by Average Grade</h6>
                        <p class="text-sm">Best performers based on assignment grades</p>
                    </div>
                </div>
            </div>

            {{-- Students With the Most Late Submissions --}}
            <div class="col-lg-4 mt-4 mb-3">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="lateStudentsChart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Top 3 Students With Most Late Submissions</h6>
                        <p class="text-sm">Students who submit late frequently</p>
                    </div>
                </div>
            </div>
        @endrole

        @role('student')
            {{-- Student Submissions Statuses --}}
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="student-status-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">My Submissions Status Overview</h6>
                        <p class="text-sm">Submitted vs Late vs Graded</p>
                    </div>
                </div>
            </div>

            {{-- Top 3 Subjects with Best Grades --}}
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="top-subjects-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Top Subjects by Average Grade</h6>
                        <p class="text-sm">Your best-performing subjects</p>
                    </div>
                </div>
            </div>

            {{-- Student Subjects With Most Late Submissions --}}
            <div class="col-lg-4 mt-4 mb-3">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="late-subjects-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Subjects With Most Late Submissions</h6>
                        <p class="text-sm">Where you struggle to submit on time</p>
                    </div>
                </div>
            </div>
        @endrole

        @role('parent')
            {{-- Children Submissions Statuses --}}
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="children-status-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Children Submissions Status Overview</h6>
                        <p class="text-sm">Submitted vs Late vs Graded</p>
                    </div>
                </div>
            </div>

            {{-- Subjects With Most Late Submissions --}}
            <div class="col-lg-4 mt-4 mb-3">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="children-late-subjects-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Subjects With Most Late Submissions</h6>
                        <p class="text-sm">Where your children struggle to submit on time</p>
                    </div>
                </div>
            </div>

            {{-- Children Average Grades --}}
            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                <div class="card z-index-2">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="children-average-grade-chart" class="chart-canvas" height="170"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Children Average Grades</h6>
                        <p class="text-sm">Average grade per child across all assignments</p>
                    </div>
                </div>
            </div>
        @endrole
    </div>

    <div class="row mb-4">
        @role('admin')
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-7">
                                <h6>Teachers Who Haven’t Graded Submissions</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-warning text-danger"></i>
                                    <span class="font-weight-bold ms-1">{{ $teachersWithUngraded->count() }}</span>
                                    teachers pending grading
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Teacher
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Assignments
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ungraded
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($teachersWithUngraded as $row)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <img src="{{ Avatar::create($row['teacher']->name)->toBase64() }}"
                                                        class="avatar avatar-sm me-3" alt="teacher">
                                                    <div class="d-flex flex-column justify-content-center text-start">
                                                        <h6 class="mb-0 text-sm">{{ $row['teacher']->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $row['teacher']->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span class="badge bg-gradient-primary text-white">
                                                    {{ $row['teacher']->assignments->count() }} Assignments
                                                </span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span class="badge bg-gradient-danger text-white">
                                                    {{ $row['ungraded_count'] }} Ungraded
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-sm text-secondary py-4">
                                                All submissions are graded — great job!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Recent Submissions</h6>
                        <p class="text-sm">
                            <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                            <span class="font-weight-bold">{{ $recentSubmissions->count() }}</span> new this week
                        </p>
                    </div>

                    <div class="card-body p-3">
                        <div class="timeline timeline-one-side">

                            @forelse($recentSubmissions as $submission)
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">

                                        {{-- Icon: graded or pending --}}
                                        @if ($submission->grade)
                                            <i class="material-icons text-success text-gradient">check_circle</i>
                                        @else
                                            <i class="material-icons text-warning text-gradient">pending</i>
                                        @endif

                                    </span>

                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">
                                            {{ $submission->student->name }}
                                            <span class="text-secondary">submitted</span>
                                            {{ $submission->assignment->title }}
                                        </h6>

                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $submission->created_at->format('d M, H:i') }}

                                            @if ($submission->grade)
                                                <span class="text-success">| Graded ({{ $submission->grade->score }})</span>
                                            @else
                                                <span class="text-warning">| Ungraded</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-sm text-secondary py-4">No recent submissions</p>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        @endrole

        @role('teacher')
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-7">
                                <h6>Students with Ungraded Submissions</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-warning text-danger"></i>
                                    <span class="font-weight-bold ms-1">{{ $studentsWithUngraded->count() }}</span>
                                    students pending grading
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Student
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ungraded Submissions
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($studentsWithUngraded as $row)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <img src="{{ Avatar::create($row['student']->name)->toBase64() }}"
                                                        class="avatar avatar-sm me-3" alt="student">
                                                    <div class="d-flex flex-column justify-content-center text-start">
                                                        <h6 class="mb-0 text-sm">{{ $row['student']->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $row['student']->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span class="badge bg-gradient-danger text-white">
                                                    {{ $row['ungraded_count'] }} Ungraded
                                                </span>
                                            </td>

                                            <td class="align-middle text-center">
                                                @if ($row['first_submission'])
                                                    <a href="{{ route('submissions.show', $row['first_submission']) }}"
                                                        class="btn btn-sm btn-primary mt-2">
                                                        Grade Now
                                                    </a>
                                                @else
                                                    <span class="text-muted">No pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-sm text-secondary py-4">
                                                All submissions are graded — great job!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Assignment Completion Timeline</h6>
                        <p class="text-sm">
                            <i class="fa fa-tasks text-primary" aria-hidden="true"></i>
                            Overview of submission progress for your assignments
                        </p>
                    </div>

                    <div class="card-body p-3">
                        <div class="timeline timeline-one-side">

                            @forelse($teacherAssignments as $assignment)
                                @php
                                    $totalStudents = $assignment->total_students;
                                    $submittedCount = $assignment->submissions_count;
                                    $submissionPercentage =
                                        $totalStudents > 0 ? ($submittedCount / $totalStudents) * 100 : 0;

                                    // Determine icon color
                                    $iconColor =
                                        $submissionPercentage == 100
                                            ? 'text-success'
                                            : ($submissionPercentage >= 50
                                                ? 'text-warning'
                                                : 'text-danger');
                                @endphp

                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-icons {{ $iconColor }} text-gradient">assignment</i>
                                    </span>

                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">
                                            {{ $assignment->title }}
                                        </h6>

                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            {{ $submittedCount }}/{{ $totalStudents }} students submitted

                                            @if ($submissionPercentage == 100)
                                                <span class="text-success">| Completed</span>
                                            @elseif($submissionPercentage >= 50)
                                                <span class="text-warning">| In Progress</span>
                                            @else
                                                <span class="text-danger">| Low Submission</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-sm text-secondary py-4">No assignments found</p>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        @endrole

        @role('student')
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        @if ($totalPendingAssignments > 6)
                            <div class="alert alert-warning text-white">
                                <strong>Heads up!</strong> You have
                                <strong>{{ $totalPendingAssignments }}</strong> pending assignments.
                                Only the first 6 are shown here. Please review all assignments!
                            </div>
                        @endif
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-7">
                                <h6>Pending Assignments</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-clock text-warning"></i>
                                    <span class="font-weight-bold ms-1">{{ $totalPendingAssignments }}</span>
                                    assignments awaiting submission
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Assignment
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Subject
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Due Date
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($studentPendingAssignments as $assignment)
                                        <tr>
                                            <td class="text-center">
                                                <h6 class="mb-0 text-sm">{{ $assignment->title }}</h6>
                                            </td>

                                            <td class="text-center">
                                                <span class="text-xs text-secondary">{{ $assignment->subject->name }}</span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-gradient-warning text-white">
                                                    {{ $assignment->due_date->format('M d, Y') }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('assignments.show', $assignment) }}"
                                                    class="btn btn-sm btn-primary mt-3">
                                                    Submit
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-sm text-secondary py-4">
                                                🎉 You're all caught up! No pending assignments.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Your Assignment Progress</h6>
                        <p class="text-sm">
                            <i class="fa fa-user text-primary"></i>
                            Track your submission progress and deadlines
                        </p>
                    </div>

                    <div class="card-body p-3">
                        <div class="timeline timeline-one-side">
                            @forelse($Studentassignments as $assignment)
                                @php
                                    $submission = $assignment->submissions->first();
                                    $now = \Carbon\Carbon::now();

                                    if ($submission) {
                                        if ($submission->status === 'graded') {
                                            $status = 'Graded';
                                            $iconColor = 'text-info';
                                        } else {
                                            $status = 'Submitted';
                                            $iconColor = 'text-success';
                                        }
                                    } else {
                                        if ($assignment->due_date < $now) {
                                            $status = 'Overdue';
                                            $iconColor = 'text-danger';
                                        } else {
                                            $status = 'Pending';
                                            $iconColor = 'text-warning';
                                        }
                                    }
                                @endphp

                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-icons {{ $iconColor }} text-gradient">
                                            assignment
                                        </i>
                                    </span>

                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">
                                            {{ $assignment->title }}
                                        </h6>

                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            Status:
                                            @if ($status === 'Submitted')
                                                <span class="text-success">Submitted</span>
                                            @elseif ($status === 'Graded')
                                                <span class="text-info">Graded</span>
                                            @elseif ($status === 'Pending')
                                                <span class="text-warning">Pending</span>
                                            @else
                                                <span class="text-danger">Overdue</span>
                                            @endif

                                            <br>
                                            <small class="text-xs">
                                                Due: {{ $assignment->due_date->format('M d, Y') }}
                                            </small>
                                        </p>
                                    </div>
                                </div>

                            @empty
                                <p class="text-center text-sm text-secondary py-4">
                                    No assignments assigned to you
                                </p>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        @endrole

        @role('parent')
            <div class="col-lg-8 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Children's Pending Assignments</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-clock text-warning"></i>
                            Overview of assignments your children have yet to submit
                        </p>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Child</th>
                                        <th class="text-center">Assignment</th>
                                        <th class="text-center">Subject</th>
                                        <th class="text-center">Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendingAssignmentsForChildren as $childName => $assignments)
                                        @foreach ($assignments as $assignment)
                                            <tr>
                                                <td class="text-center">{{ $childName }}</td>
                                                <td class="text-center">{{ $assignment->title }}</td>
                                                <td class="text-center">{{ $assignment->subject->name }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-gradient-warning text-white">
                                                        {{ $assignment->due_date->format('M d, Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-sm text-secondary py-4">
                                                🎉 All your children are up to date!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Children Progress Timeline</h6>
                        <p class="text-sm">
                            <i class="fa fa-user text-primary"></i>
                            See how your children are progressing in their assignments
                        </p>
                    </div>

                    <div class="card-body p-3">
                        @forelse($childrenProgressTimeline as $childName => $progress)
                            <h6 class="text-primary mt-3 mb-2">{{ $childName }}</h6>

                            <div class="timeline timeline-one-side mb-4">
                                @php
                                    $percentage = $progress['percentage'];
                                    if ($percentage >= 80) {
                                        $iconColor = 'text-success';
                                        $status = 'On Track';
                                    } elseif ($percentage >= 50) {
                                        $iconColor = 'text-warning';
                                        $status = 'Needs Attention';
                                    } else {
                                        $iconColor = 'text-danger';
                                        $status = 'Behind';
                                    }
                                @endphp

                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="material-icons {{ $iconColor }} text-gradient">trending_up</i>
                                    </span>

                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">
                                            {{ $progress['submitted'] }}/{{ $progress['total'] }} Assignments Submitted
                                        </h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            Progress: <span class="{{ $iconColor }}">{{ $percentage }}%
                                                ({{ $status }})
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-sm text-secondary py-4">No children found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endrole
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // === Admin Dashboard Charts ===
            var chartBarsEl = document.getElementById("chart-bars");
            if (chartBarsEl) {
                var gradeLabels = @json($grades->pluck('name'));
                var gradeData = @json($grades->pluck('students_count'));
                new Chart(chartBarsEl.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: gradeLabels,
                        datasets: [{
                            label: "Students",
                            tension: 0.4,
                            borderWidth: 0,
                            borderRadius: 4,
                            borderSkipped: false,
                            backgroundColor: "rgba(255, 255, 255, .8)",
                            data: gradeData,
                            maxBarThickness: 40
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(255, 255, 255, .2)'
                                },
                                ticks: {
                                    beginAtZero: true,
                                    color: "#fff",
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: "Roboto"
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(255, 255, 255, .2)'
                                },
                                ticks: {
                                    display: true,
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: "Roboto"
                                    }
                                }
                            }
                        }
                    },
                });
            }

            var chartLineEl = document.getElementById("chart-line");
            if (chartLineEl) {
                new Chart(chartLineEl.getContext("2d"), {
                    type: "line",
                    data: {
                        labels: @json($submissionDates),
                        datasets: [{
                            label: "Assignments Submitted",
                            tension: 0.3,
                            borderWidth: 4,
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(255, 255, 255, .8)",
                            pointBorderColor: "transparent",
                            borderColor: "rgba(255, 255, 255, .8)",
                            backgroundColor: "transparent",
                            fill: true,
                            data: @json($submissionCounts),
                            maxBarThickness: 6
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5],
                                    color: 'rgba(255,255,255,.2)'
                                },
                                ticks: {
                                    display: true,
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: "Roboto"
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        weight: 300,
                                        family: "Roboto"
                                    }
                                }
                            }
                        }
                    }
                });
            }

            var gradedPieEl = document.getElementById("graded-ungraded-chart");
            if (gradedPieEl) {
                new Chart(gradedPieEl.getContext("2d"), {
                    type: "pie",
                    data: {
                        labels: ["Graded", "Ungraded"],
                        datasets: [{
                            data: [{{ $graded }}, {{ $ungraded }}],
                            backgroundColor: ["rgba(76, 175, 80, 0.9)", "rgba(244, 67, 54, 0.9)"],
                            borderColor: ["rgba(76, 175, 80, 1)", "rgba(244, 67, 54, 1)"],
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: "#ffffff"
                                }
                            }
                        }
                    }
                });
            }

            // === Teacher Dashboard Chart ===
            var statusEl = document.getElementById("status-chart");
            if (statusEl) {
                var statusLabels = ["Submitted", "Late", "Graded"];
                var statusData = [
                    {{ $submissionStatusCounts['submitted'] }},
                    {{ $submissionStatusCounts['late'] }},
                    {{ $submissionStatusCounts['graded'] }}
                ];

                new Chart(statusEl.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            label: "Submissions",
                            tension: 0.4,
                            borderWidth: 0,
                            borderRadius: 4,
                            backgroundColor: ["#fbc658", "#fc6e51", "#2dce89"],
                            data: statusData,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    borderDash: [5, 5],
                                    color: 'rgba(255,255,255,.2)'
                                },
                                ticks: {
                                    color: "#fff",
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        family: "Roboto"
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false
                                },
                                ticks: {
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        family: "Roboto"
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Top Students Chart
            var ctxTopStudentsEl = document.getElementById("top-students-chart");
            if (ctxTopStudentsEl) {
                var studentLabels = @json($topStudents->map(fn($item) => $item['student']->name));
                var studentScores = @json($topStudents->pluck('avg_score'));

                new Chart(ctxTopStudentsEl.getContext("2d"), {
                    type: 'bar',
                    data: {
                        labels: studentLabels,
                        datasets: [{
                            label: 'Average Grade',
                            data: studentScores,
                            backgroundColor: 'rgba(255, 206, 86, 0.8)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    color: '#fff',
                                    stepSize: 10
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#fff'
                                }
                            }
                        }
                    }
                });
            }

            // Late Students Chart
            var ctxLateEl = document.getElementById('lateStudentsChart');
            if (ctxLateEl) {
                var lateStudentsLabels = @json($lateStudentsList->pluck('name'));
                var lateStudentsCounts = @json($lateStudentsList->pluck('late_count'));

                new Chart(ctxLateEl.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: lateStudentsLabels,
                        datasets: [{
                            label: 'Late Submissions',
                            data: lateStudentsCounts,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // === Student Dashboard Chart ===
            var studentStatusEl = document.getElementById("student-status-chart");
            if (studentStatusEl) {
                var studentStatusLabels = ["Submitted", "Late", "Graded"];
                var studentStatusData = [
                    {{ $studentSubmissionStatusCounts['submitted'] }},
                    {{ $studentSubmissionStatusCounts['late'] }},
                    {{ $studentSubmissionStatusCounts['graded'] }}
                ];

                new Chart(studentStatusEl.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: studentStatusLabels,
                        datasets: [{
                            label: "My Submissions",
                            tension: 0.4,
                            borderWidth: 0,
                            borderRadius: 4,
                            backgroundColor: ["#fbc658", "#fc6e51", "#2dce89"],
                            data: studentStatusData,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    borderDash: [5, 5],
                                    color: 'rgba(255,255,255,.2)'
                                },
                                ticks: {
                                    color: "#fff",
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        family: "Roboto"
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false
                                },
                                ticks: {
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        family: "Roboto"
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Top Subjects Chart
            var topSubjectsEl = document.getElementById("top-subjects-chart");
            if (topSubjectsEl) {

                var subjectLabels = @json($topSubjects->pluck('subject_name'));
                var subjectScores = @json($topSubjects->pluck('avg_score'));

                new Chart(topSubjectsEl.getContext("2d"), {
                    type: 'bar',
                    data: {
                        labels: subjectLabels,
                        datasets: [{
                            label: 'Average Grade',
                            data: subjectScores,
                            backgroundColor: 'rgba(45, 206, 137, 0.8)', // green-ish
                            borderColor: 'rgba(45, 206, 137, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    color: '#fff',
                                    stepSize: 10
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#fff'
                                }
                            }
                        }
                    }
                });
            }

            // Late Subjects Chart
            var lateSubjectsEl = document.getElementById("late-subjects-chart");
            if (lateSubjectsEl) {
                var lateSubjectsLabels = @json($lateSubjects->pluck('subject_name'));
                var lateSubjectsCounts = @json($lateSubjects->pluck('late_count'));

                new Chart(lateSubjectsEl.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: lateSubjectsLabels,
                        datasets: [{
                            label: "Late Submissions",
                            data: lateSubjectsCounts,
                            backgroundColor: "rgba(252, 86, 83, 0.8)",
                            borderColor: "rgba(252, 86, 83, 1)",
                            borderWidth: 2,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // === Parent Dashboard Chart ===
            var childrenStatusEl = document.getElementById("children-status-chart");
            if (childrenStatusEl) {
                var childrenStatusLabels = ["Submitted", "Late", "Graded"];
                var childrenStatusData = [
                    {{ $childrenSubmissionStatusCounts['submitted'] }},
                    {{ $childrenSubmissionStatusCounts['late'] }},
                    {{ $childrenSubmissionStatusCounts['graded'] }}
                ];

                new Chart(childrenStatusEl.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: childrenStatusLabels,
                        datasets: [{
                            label: "Children Submissions",
                            tension: 0.4,
                            borderWidth: 0,
                            borderRadius: 4,
                            backgroundColor: ["#fbc658", "#fc6e51", "#2dce89"],
                            data: childrenStatusData,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    borderDash: [5, 5],
                                    color: 'rgba(255,255,255,.2)'
                                },
                                ticks: {
                                    color: "#fff",
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        family: "Roboto"
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false
                                },
                                ticks: {
                                    color: '#f8f9fa',
                                    padding: 10,
                                    font: {
                                        size: 14,
                                        family: "Roboto"
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Late Subjects Chart
            var childrenLateSubjectsEl = document.getElementById("children-late-subjects-chart");
            if (childrenLateSubjectsEl) {
                new Chart(childrenLateSubjectsEl.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: @json($ParentLateSubjects->pluck('subject_name')),
                        datasets: [{
                            label: "Late Submissions",
                            data: @json($ParentLateSubjects->pluck('late_count')),
                            backgroundColor: "rgba(252, 86, 83, 0.8)",
                            borderColor: "rgba(252, 86, 83, 1)",
                            borderWidth: 2,
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Children average grades
            var avgGradeEl = document.getElementById("children-average-grade-chart");
            if (avgGradeEl) {
                var childrenLabels = @json($childrenAvgGrades->pluck('name'));
                var childrenGrades = @json($childrenAvgGrades->pluck('avg_grade'));

                new Chart(avgGradeEl.getContext("2d"), {
                    type: "bar",
                    data: {
                        labels: childrenLabels,
                        datasets: [{
                            label: "Average Grade",
                            data: childrenGrades,
                            backgroundColor: childrenGrades.map(g => g >= 90 ? "#2dce89" : (g >=
                                70 ? "#fbc658" : "#fc6e51")),
                            borderColor: "#fff",
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    stepSize: 10
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#fff'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
