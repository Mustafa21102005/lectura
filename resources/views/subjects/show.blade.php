@extends('layouts.dashboard')

@section('title', 'Subject')

@section('page_header', 'Subject')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">Subject</h5>

                        @role('teacher')
                            <x-back-button :href="route('teacher.subjects.index')">
                                My Subjects
                            </x-back-button>
                        @endrole
                        @role('admin')
                            <x-back-button :href="route('subjects.index')">
                                Subjects
                            </x-back-button>
                        @endrole
                        @role('student')
                            <x-back-button :href="route('student.subjects.index')">
                                My Subjects
                            </x-back-button>
                        @endrole
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <h4 class="text-center my-4">Subject Details</h4>
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
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Teachers
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @role('admin|teacher')
                                    <td class="text-center">{{ $subject->id }}</td>
                                @endrole
                                <td class="text-center">{{ $subject->name }}</td>
                                <td class="text-center">
                                    @if ($teachers->isNotEmpty())
                                        @foreach ($teachers as $teacher)
                                            <div>
                                                @role('admin|parent')
                                                    <a href="{{ route('users.show', $teacher) }}">
                                                        {{ $teacher->name }}
                                                    </a>
                                                @endrole
                                                @role('teacher|student')
                                                    {{ $teacher->name }}
                                                @endrole
                                            </div>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="text-center my-4">Grades & Sections</h4>
                    <table id="grade-levels" class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Grade
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Sections
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gradesWithSections as $grade)
                                <tr>
                                    <td class="text-center">
                                        <a href="{{ route('grade-levels.show', $grade['model']) }}">
                                            {{ $grade['name'] }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if ($grade['sections']->count())
                                            {{ $grade['sections']->pluck('name')->join(', ') }}
                                        @else
                                            <span class="text-muted">No sections</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h4 class="text-center my-4">Curriculums</h4>
                    <table id="curriculums" class="table align-middle mb-0">
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
                            @foreach ($curriculums as $curriculum)
                                <tr>
                                    @role('admin|teacher')
                                        <td class="text-center">{{ $curriculum->id }}</td>
                                    @endrole
                                    <td class="text-center">
                                        <a href="{{ route('curriculums.show', $curriculum) }}">
                                            {{ $curriculum->name }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h4 class="text-center my-4">Assignments</h4>
                    <table id="assignments" class="table table-bordered align-middle mb-0">
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
                                    Title
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    @role('admin|teacher')
                                        <td class="text-center">{{ $assignment->id }}</td>
                                    @endrole
                                    <td class="text-center">{{ $assignment->title }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.fn.dataTable.ext.errMode = 'none'; // disables console warnings

        let tableCurriculum = new DataTable('#curriculums', {
            responsive: true,
            language: {
                emptyTable: "No curriculums found."
            }
        });

        let tableAssignment = new DataTable('#assignments', {
            responsive: true,
            language: {
                emptyTable: "No assignments found."
            }
        });

        let tablegradelevels = new DataTable('#grade-levels', {
            responsive: true,
            language: {
                emptyTable: "No grade levels found."
            }
        });
    </script>
@endsection
