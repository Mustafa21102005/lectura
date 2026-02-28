@extends('layouts.dashboard')

@section('title', 'My Info')

@section('page_header', 'My Info')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h5 class="text-white text-capitalize ps-3">Enrolled In</h5>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="student" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">Curriculum</th>
                                    <th class="text-center">Grade Level</th>
                                    <th class="text-center">Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollments as $enrollment)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('curriculums.show', $enrollment['curriculum']) }}">
                                                {{ $enrollment['curriculum']->name }}
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            @if ($enrollment['grade_level'])
                                                <a
                                                    href="{{ route('grade-levels.show', $enrollment['grade_level']->slug) }}">
                                                    {{ $enrollment['grade_level']->name }}
                                                </a>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            {{ $enrollment['section']->name ?? 'N/A' }}
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
        $.fn.dataTable.ext.errMode = 'none';

        new DataTable('#student', {
            responsive: true,
            language: {
                emptyTable: "No enrollments found."
            }
        });
    </script>
@endsection
