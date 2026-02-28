@extends('layouts.dashboard')

@section('title', 'Curriculums')

@section('page_header', 'Curriculums')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="float-end me-3">
                            <x-create-button href="{{ route('curriculums.create') }}" />
                        </div>
                        <h5 class="text-white text-capitalize ps-3">Curriculums table</h5>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="curriculums" class="table table-bordered align-middle mb-0">
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
                                @foreach ($curriculums as $curriculum)
                                    <tr>
                                        <td class="text-center">{{ $curriculum->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('curriculums.show', $curriculum) }}">
                                                {{ $curriculum->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <x-edit-button :href="route('curriculums.edit', $curriculum)" />
                                            <x-delete-button :action="route('curriculums.destroy', $curriculum)" :item="'Curriculum: ' . $curriculum->name" :id="$curriculum->id" />
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

        let table = new DataTable('#curriculums', {
            responsive: true,
            language: {
                emptyTable: "No curriculums found."
            }
        });
    </script>
@endsection
