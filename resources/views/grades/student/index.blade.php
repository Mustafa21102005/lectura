@extends('layouts.dashboard')

@section('title', 'My Grades')

@section('page_header', 'My Grades')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h5 class="text-white text-capitalize ps-3">My Grades table</h5>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="grades" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Assignment
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Mark
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Remarks
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grades as $grade)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('assignments.show', $grade->submission->assignment) }}">
                                                {{ $grade->submission->assignment->title }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $grade->score }}/{{ $grade->submission->assignment->max_score }}
                                        </td>
                                        <td class="text-center">
                                            {{ Str::limit($grade->remarks ?? 'No remarks', 50) . '...' }}
                                        </td>
                                        <td class="text-center">
                                            <a class="btn bg-gradient-info mt-3"
                                                href="{{ route('grades.show', $grade->id) }}">
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

        let table = new DataTable('#grades', {
            responsive: true,
            language: {
                emptyTable: "No grades found."
            }
        });
    </script>
@endsection
