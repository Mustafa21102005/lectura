@extends('layouts.dashboard')

@section('title', 'Grade Level')

@section('page_header', 'Grade Level')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">Grade Level Details</h5>

                        @role('student')
                            <x-back-button :href="route('student.info')">
                                My Info
                            </x-back-button>
                        @endrole
                        @role('teacher')
                            <x-back-button :href="route('teacher.subjects.index')">
                                My Subjects
                            </x-back-button>
                        @endrole
                        @role('admin')
                            <x-back-button :href="route('grade-levels.index')">
                                Grade Level
                            </x-back-button>
                        @endrole
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <h4 class="text-center my-4">Grade Level Information</h4>
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                @role('admin|teacher')
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                @endrole
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @role('admin|teacher')
                                    <td class="text-center">{{ $gradeLevel->id }}</td>
                                @endrole
                                <td class="text-center">{{ $gradeLevel->name }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @role('admin')
                        <h4 class="text-center my-4">Sections</h4>
                        <table id="sections" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sections as $section)
                                    <tr>
                                        <td class="text-center">{{ $section->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('sections.show', $section->gradeLevel) }}">
                                                {{ $section->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endrole

                    <h4 class="text-center my-4">Subjects</h4>
                    <table id="subjects" class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                @role('admin|teacher')
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                @endrole
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    @role('admin|teacher')
                                        <td class="text-center">{{ $subject->id }}</td>
                                    @endrole
                                    <td class="text-center">
                                        <a href="{{ route('subjects.show', $subject) }}">
                                            {{ $subject->name }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @role('admin|teacher')
                        <h4 class="text-center my-4">Teachers</h4>
                        <table id="teachers" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td class="text-center">{{ $teacher->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $teacher->id) }}">
                                                {{ $teacher->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h4 class="text-center my-4">Students</h4>
                        <table id="students" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="text-center">{{ $student->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $student->id) }}">
                                                {{ $student->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    @endrole

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.fn.dataTable.ext.errMode = 'none'; // disables console warnings

        let tableStudents = new DataTable('#students', {
            responsive: true,
            language: {
                emptyTable: "No students found."
            }
        });

        let tableTeachers = new DataTable('#teachers', {
            responsive: true,
            language: {
                emptyTable: "No teachers found."
            }
        });

        let tableSubjects = new DataTable('#subjects', {
            responsive: true,
            language: {
                emptyTable: "No subjects found."
            }
        });

        let tableSections = new DataTable('#sections', {
            responsive: true,
            language: {
                emptyTable: "No sections found."
            }
        });
    </script>
@endsection
