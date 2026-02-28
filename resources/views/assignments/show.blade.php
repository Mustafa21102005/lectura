@extends('layouts.dashboard')

@section('title', 'Assignment')

@section('page_header', 'Assignment')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">Assignment Details</h5>

                        @role('parent')
                            <x-back-button :href="route('parent.assignments.index')">
                                Child Assignments
                            </x-back-button>
                        @endrole

                        @role('student')
                            <x-back-button :href="route('student.assignments.index')">
                                My Assignments
                            </x-back-button>
                        @endrole

                        @role('teacher')
                            <x-back-button :href="route('assignments.index')">
                                Assignments
                            </x-back-button>
                        @endrole
                    </div>
                </div>
                <div class="card-body px-0 pb-2">

                    <h4 class="text-center my-4">Assignment Information</h4>
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
                                    Title
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Description
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Subject
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Grade Level
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Teacher
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Due Date
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Mark
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
                                    <td class="text-center">{{ $assignment->id }}</td>
                                @endrole
                                <td class="text-center">{{ $assignment->title }}</td>
                                <td class="text-center text-wrap">
                                    {{ $assignment->description ?? 'No Description' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('subjects.show', $assignment->subject) }}">
                                        {{ $assignment->subject->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('grade-levels.show', $assignment->grade_level) }}">
                                        {{ $assignment->grade_level->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{ $assignment->teacher->name }}
                                </td>
                                <td class="text-center">{{ $assignment->due_date }}</td>
                                <td class="text-center">{{ $assignment->max_score }}</td>
                                <td class="text-center">
                                    @php
                                        $statusClass = match (strtolower($assignment->status)) {
                                            'on-time' => 'bg-success text-white',
                                            'late' => 'bg-warning text-white',
                                            'closed' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($assignment->status) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="text-center my-4">Media Files</h4>
                    @if ($media->isNotEmpty())
                        <table class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    @role('teacher')
                                        <th
                                            class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                    @endrole
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        File Name
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        View / Download
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($media as $file)
                                    <tr>
                                        @role('teacher')
                                            <td class="text-center">{{ $file['id'] }}</td>
                                        @endrole
                                        <td class="text-center">{{ $file['name'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ $file['url'] }}" target="_blank"
                                                class="btn btn-sm btn-primary mt-3">
                                                View
                                            </a>
                                            <a href="{{ $file['url'] }}" download class="btn btn-sm btn-secondary mt-3">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">No media files uploaded yet.</p>
                    @endif

                    @role('student')
                        <div class="text-center my-5">
                            @php
                                $studentSubmission = $assignment
                                    ->submissions()
                                    ->where('student_id', auth()->id())
                                    ->first();
                            @endphp

                            @if ($studentSubmission)
                                <p class="text-success fw-bold">
                                    You have already submitted this assignment ✅
                                </p>
                            @else
                                @can('submit-assignment', $assignment)
                                    <a href="{{ route('submissions.create', ['assignment' => $assignment]) }}"
                                        class="btn btn-primary">
                                        Submit Assignment
                                    </a>
                                @else
                                    <p class="text-danger fw-bold">
                                        This assignment cannot be submitted at this time ❌
                                    </p>
                                @endcan
                            @endif
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endsection
