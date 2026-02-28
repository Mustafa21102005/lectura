@extends('layouts.dashboard')

@section('title', 'Sections')

@section('page_header', 'Sections')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Sections table</h6>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="sections" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Grade
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Sections
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grades as $grade)
                                    <tr>
                                        <td class="text-center">{{ $grade->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('grade-levels.show', $grade) }}">
                                                {{ $grade->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if ($grade->sections->count())
                                                {{ $grade->sections->pluck('name')->join(', ') }}
                                            @else
                                                <span class="text-muted">No sections</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a class="btn bg-gradient-info mt-3"
                                                href="{{ route('sections.show', $grade) }}">
                                                Manage
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

        let table = new DataTable('#sections', {
            responsive: true,
            language: {
                emptyTable: "No sections found."
            }
        });
    </script>
@endsection
