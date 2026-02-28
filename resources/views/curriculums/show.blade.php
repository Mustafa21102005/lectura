@extends('layouts.dashboard')

@section('title', 'Curriculum')

@section('page_header', 'Curriculum')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">Curriculum</h5>

                        @role('student')
                            <x-back-button :href="route('student.info')">
                                My Info
                            </x-back-button>
                        @endrole
                        @role('admin')
                            <x-back-button :href="route('curriculums.index')">
                                Curriculums
                            </x-back-button>
                        @endrole
                    </div>
                </div>
                <div class="card-body px-4 pb-2">

                    <h4 class="text-center my-4">Curriculum Details</h4>
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
                                    <td class="text-center">{{ $curriculum->id }}</td>
                                @endrole
                                <td class="text-center">{{ $curriculum->name }}</td>
                            </tr>
                        </tbody>
                    </table>

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

                    @role('admin')
                        <h4 class="text-center my-4">Students</h4>
                        <table id="students" class="table align-middle mb-0">
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
                                            <a href="{{ route('users.show', $student) }}">
                                                {{ $student->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
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

        let tableSubjects = new DataTable('#subjects', {
            responsive: true,
            language: {
                emptyTable: "No subjects found."
            }
        });

        let tableStudents = new DataTable('#students', {
            responsive: true,
            language: {
                emptyTable: "No students found."
            }
        });
    </script>
@endsection
