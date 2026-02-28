@extends('layouts.dashboard')

@section('title', 'My Subjects')

@section('page_header', 'My Subjects')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Subjects Table</h6>
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
                                        Grades
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Curriculums
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $item)
                                    @php
                                        $subject = $item['subject'];
                                        $grades = $item['grades'];
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $subject->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('subjects.show', $subject) }}">{{ $subject->name }}</a>
                                        </td>
                                        <td class="text-center text-wrap">
                                            {{ $grades->isNotEmpty() ? $grades->implode(', ') : 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            @foreach ($subject->curricula as $curriculum)
                                                <span class="badge bg-primary">{{ $curriculum->name }}</span>
                                            @endforeach
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

        new DataTable('#subjects', {
            responsive: true,
            language: {
                emptyTable: "No subjects found."
            }
        });
    </script>
@endsection
