@extends('layouts.dashboard')

@section('title', 'Grade')

@section('page_header', 'Grade')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">Grade Details</h5>

                        @role('student')
                            <x-back-button :href="route('student.grades.index')">
                                My Grades
                            </x-back-button>
                        @endrole
                        @role('teacher')
                            <x-back-button :href="route('grades.index')">
                                Grades
                            </x-back-button>
                        @endrole
                    </div>
                </div>
                <div class="card-body px-0 pb-2">

                    <h4 class="text-center my-4">Grade Information</h4>
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                @role('teacher')
                                    <th scope="col"
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                @endrole
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Mark
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Remark
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Assignment
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Student
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @role('teacher')
                                    <td class="text-center">{{ $grade->id }}</td>
                                @endrole
                                <td class="text-center text-wrap">
                                    {{ $grade->score }}/{{ $grade->submission->assignment->max_score }}
                                </td>
                                <td class="text-center">{{ $grade->remarks ?? 'No Remarks' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('assignments.show', $grade->submission->assignment) }}">
                                        {{ $grade->submission->assignment->title }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @role('teacher')
                                        <a href="{{ route('users.show', $grade->student) }}">
                                            {{ $grade->student->name }}
                                        </a>
                                    @endrole
                                    @role('student|parent')
                                        {{ $grade->student->name }}
                                    @endrole
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusClass = match (strtolower($grade->submission->status)) {
                                            'submitted' => 'bg-primary text-white',
                                            'graded' => 'bg-success text-white',
                                            'late' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($grade->submission->status) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
