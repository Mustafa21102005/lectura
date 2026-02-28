@extends('layouts.dashboard')

@section('title', 'Subjects')

@section('page_header', 'Subjects')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="float-end me-3">
                            <x-create-button href="{{ route('subjects.create') }}" />
                        </div>
                        <h6 class="text-white text-capitalize ps-3">Subjects table</h6>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="subjects" class="table table-bordered align-middle mb-0">
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
                                        Teacher
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Curriculum
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                    <tr>
                                        <td class="text-center">{{ $subject->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('subjects.show', $subject) }}">
                                                {{ $subject->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $subject->assignedTeachers->first()) }}">
                                                {{ $subject->assignedTeachers->first()->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @foreach ($subject->curricula as $curriculum)
                                                <span class="badge bg-primary">{{ $curriculum->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <x-edit-button :href="route('subjects.edit', $subject)" />
                                            <x-delete-button :action="route('subjects.destroy', $subject)" :item="'Subject: ' . $subject->name" :id="$subject->id" />
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

        let table = new DataTable('#subjects', {
            responsive: true,
            language: {
                emptyTable: "No subjects found."
            }
        });
    </script>
@endsection
