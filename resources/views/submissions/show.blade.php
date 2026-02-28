@extends('layouts.dashboard')

@section('title', 'Submission')

@section('page_header', 'Submission')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">Submission Details</h5>

                        @role('student')
                            <x-back-button :href="route('student.submissions.index')">
                                My Submissions
                            </x-back-button>
                        @endrole
                        @role('parent')
                            <x-back-button :href="route('parent.submissions.index')">
                                Child Submissions
                            </x-back-button>
                        @endrole
                        @role('teacher')
                            <x-back-button :href="route('submissions.index')">
                                Submissions
                            </x-back-button>
                        @endrole
                    </div>
                </div>
                <div class="card-body px-0 pb-2">

                    <h4 class="text-center my-4">Submission Information</h4>
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
                                    Assignment
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Student
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Remarks
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @role('admin|teacher')
                                    <td class="text-center">{{ $submission->id }}</td>
                                @endrole
                                <td class="text-center">
                                    <a href="{{ route('assignments.show', $submission->assignment) }}">
                                        {{ $submission->assignment->title }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @role('admin|teacher')
                                        <a href="{{ route('users.show', $submission->student) }}">
                                            {{ $submission->student->name }}
                                        </a>
                                    @endrole
                                    @role('student|parent')
                                        {{ $submission->student->name }}
                                    @endrole
                                </td>
                                <td class="text-center text-wrap">
                                    {{ $submission->remarks ?? 'No Remarks' }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusClass = match (strtolower($submission->status)) {
                                            'submitted' => 'bg-primary text-white',
                                            'graded' => 'bg-success text-white',
                                            'late' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($submission->status) }}
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
                                    @role('admin|teacher')
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
                                        Preview / Download
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($media as $file)
                                    <tr>
                                        @role('admin|teacher')
                                            <td class="text-center">{{ $file['id'] }}</td>
                                        @endrole
                                        <td class="text-center">{{ $file['name'] }}</td>
                                        <td class="text-center">
                                            <a href="{{ $file['url'] }}" target="_blank"
                                                class="btn btn-sm btn-primary mt-2">
                                                View
                                            </a>
                                            <a href="{{ $file['url'] }}" download class="btn btn-sm btn-secondary mt-2">
                                                Download
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted text-center">No media files uploaded</p>
                    @endif

                    @role('teacher')
                        {{-- Grading Section --}}
                        <div class="text-center my-5">
                            @if ($submission->status !== 'graded')
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#gradeModal">
                                    Grade Submission
                                </button>
                            @else
                                <p class="text-success fw-bold">This submission has been graded ✅</p>
                            @endif
                        </div>

                        {{-- Modal --}}
                        <div class="modal fade" id="gradeModal" tabindex="-1" aria-hidden="true"
                            aria-labelledby="gradeModalLabel">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('grades.store') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="submission_id" value="{{ $submission->id }}">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Grade Assignment</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">

                                            <small class="text-muted">
                                                Maximum Mark: {{ $submission->assignment->max_score }}
                                            </small>

                                            {{-- Mark --}}
                                            <div class="input-group input-group-outline my-3">
                                                <label for="score" class="form-label">Score</label>
                                                <input type="number" name="score" id="score" class="form-control"
                                                    min="0" max="{{ $submission->assignment->max_score }}" required>
                                            </div>

                                            {{-- Remarks --}}
                                            <div class="input-group input-group-outline my-3">
                                                <textarea name="remarks" id="remarks" class="form-control" style="min-height: 50px;" rows="5"
                                                    placeholder="Add feedback for the student..."></textarea>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-success">Submit Grade</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endrole

                </div>
            </div>
        </div>
    </div>
@endsection
