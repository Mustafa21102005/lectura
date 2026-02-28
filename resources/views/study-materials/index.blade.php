@extends('layouts.dashboard')

@section('title', 'Study Materials')

@section('page_header', 'Study Materials')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="float-end me-3">
                            <x-create-button href="{{ route('study-materials.create') }}" />
                        </div>
                        <h6 class="text-white text-capitalize ps-3">Study Materials table</h6>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="study-materials" class="table table-bordered align-middle mb-0">
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
                                        Teacher
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Material Type
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $material)
                                    <tr>
                                        <td class="text-center">{{ $material->id }}</td>
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
                                            @role('admin')
                                                <a href="{{ route('users.show', $material->teacher) }}">
                                                    {{ $material->teacher->name }}
                                                </a>
                                            @endrole
                                            @role('teacher')
                                                {{ $material->teacher->name }}
                                            @endrole
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('material-types.show', $material->type) }}">
                                                {{ $material->type->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <x-edit-button :href="route('study-materials.edit', $material)" />
                                            <x-delete-button :action="route('study-materials.destroy', $material)" :item="'Study Material: ' . $material->title" :id="$material->id"
                                                :id="$material->id" />
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
