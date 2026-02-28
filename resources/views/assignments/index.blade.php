@extends('layouts.dashboard')

@section('title', 'Assignments')

@section('page_header', 'Assignments')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="float-end me-3">
                            <x-create-button href="{{ route('assignments.create') }}" />
                        </div>
                        <h5 class="text-white text-capitalize ps-3">Assignments table</h5>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="assignments" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Title
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Subject
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Grade Level
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Due Date
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Mark
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    <tr>
                                        <td class="text-center">{{ $assignment->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('assignments.show', $assignment) }}">
                                                {{ $assignment->title }}
                                            </a>
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
                                            {{ $assignment->due_date }}
                                        </td>
                                        <td class="text-center">
                                            {{ $assignment->max_score }}
                                        </td>
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
                                        <td class="text-center">
                                            @can('update', $assignment)
                                                <x-edit-button :href="route('assignments.edit', $assignment)" />
                                            @endcan
                                            <x-delete-button :action="route('assignments.destroy', $assignment)" :item="'Assignment: ' . $assignment->title" :id="$assignment->id" />
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

        let table = new DataTable('#assignments', {
            responsive: true,
            language: {
                emptyTable: "No assignments found."
            }
        });
    </script>
@endsection
