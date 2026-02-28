@extends('layouts.dashboard')

@section('title', 'My Submissions')

@section('page_header', 'My Submissions')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h5 class="text-white text-capitalize ps-3">My Submissions table</h5>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="submissions" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Assignment
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Remarks
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Submission Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Assignment Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submissions as $submission)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('assignments.show', $submission->assignment) }}">
                                                {{ $submission->assignment->title }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ Str::limit($submission->remarks ?? 'No remarks', 50) . '...' }}
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $assignmentStatus = strtolower($submission->status);

                                                $statusClass = match ($assignmentStatus) {
                                                    'graded' => 'bg-success text-white',
                                                    'late' => 'bg-danger text-white',
                                                    'submitted' => 'bg-primary text-white',
                                                    default => 'bg-secondary text-white',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ ucfirst($assignmentStatus) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $assignmentStatus = strtolower($submission->assignment->status);

                                                $statusClass = match ($assignmentStatus) {
                                                    'on-time' => 'bg-success text-white',
                                                    'late' => 'bg-warning text-white',
                                                    'closed' => 'bg-danger text-white',
                                                    default => 'bg-secondary text-white',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ ucfirst($assignmentStatus) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @can('update', $submission)
                                                <x-edit-button :href="route('submissions.edit', $submission->id)" />
                                            @endcan
                                            <a href="{{ route('submissions.show', $submission) }}"
                                                class="btn btn-primary mt-3">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $.fn.dataTable.ext.errMode = 'none'; // disables console warnings

        let table = new DataTable('#submissions', {
            responsive: true,
            language: {
                emptyTable: "No submissions found."
            }
        });
    </script>
@endsection
