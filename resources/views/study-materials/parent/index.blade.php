@extends('layouts.dashboard')

@section('title', 'Child Study Materials')

@section('page_header', 'Child Study Materials')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Child Study Materials table</h6>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="study-materials" class="table table-bordered align-middle mb-0">
                            <thead>
                                <tr>
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
                                        Teacher
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Material Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $material)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('study-materials.show', $material) }}">
                                                {{ $material->title }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('subjects.show', $material->subject) }}">
                                                {{ $material->subject->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $material->teacher->name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $material->type->name }}
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

        let table = new DataTable('#study-materials', {
            responsive: true,
            language: {
                emptyTable: "No study materials found."
            }
        });
    </script>
@endsection
