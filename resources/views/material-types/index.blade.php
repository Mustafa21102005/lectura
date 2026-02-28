@extends('layouts.dashboard')

@section('title', 'Material Types')

@section('page_header', 'Material Types')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="float-end me-3">
                            <x-create-button href="{{ route('material-types.create') }}" />
                        </div>
                        <h6 class="text-white text-capitalize ps-3">Material Types table</h6>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="types" class="table table-bordered align-middle mb-0">
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
                                @foreach ($materials as $material)
                                    <tr>
                                        <td class="text-center">{{ $material->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('material-types.show', $material) }}">
                                                {{ $material->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <x-edit-button :href="route('material-types.edit', $material)" />
                                            <x-delete-button :action="route('material-types.destroy', $material)" :item="'Material Type: ' . $material->name" :id="$material->id" />
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

        let table = new DataTable('#types', {
            responsive: true,
            language: {
                emptyTable: "No material types found."
            }
        });
    </script>
@endsection
