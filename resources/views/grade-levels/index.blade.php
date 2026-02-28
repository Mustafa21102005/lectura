@extends('layouts.dashboard')

@section('title', 'Grade Levels')

@section('page_header', 'Grade Levels')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="float-end me-3">
                            <x-create-button href="{{ route('grade-levels.create') }}" />
                        </div>
                        <h5 class="text-white text-capitalize ps-3">Grade Levels table</h5>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="grade-levels" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gradeLevels as $gradeLevel)
                                    <tr>
                                        <td class="text-center">{{ $gradeLevel->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('grade-levels.show', $gradeLevel) }}">
                                                {{ $gradeLevel->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <x-edit-button :href="route('grade-levels.edit', $gradeLevel)" />
                                            <x-delete-button :action="route('grade-levels.destroy', $gradeLevel)" :item="'Grade Level: ' . $gradeLevel->name" :id="$gradeLevel->id" />
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

        let table = new DataTable('#grade-levels', {
            responsive: true,
            language: {
                emptyTable: "No grade levels found."
            }
        });
    </script>
@endsection
