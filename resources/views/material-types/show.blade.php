@extends('layouts.dashboard')

@section('title', 'Material Type')

@section('page_header', 'Material Type')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h5 class="text-white text-capitalize ps-3">Material Type Details</h5>

                        <x-back-button :href="route('material-types.index')">
                            Material Types
                        </x-back-button>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <h4 class="text-center my-4">Material Type Information</h4>
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    ID
                                </th>
                                <th scope="col"
                                    class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Name
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{ $materialType->id }}</td>
                                <td class="text-center">{{ $materialType->name }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="text-center my-4">{{ $materialType->name }} Study Materials</h4>

                    <table id="study-materials" class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    ID
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Title
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studyMaterials as $material)
                                <tr>
                                    <td class="text-center">{{ $material->id }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('study-materials.show', $material) }}">
                                            {{ $material->title }}
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
