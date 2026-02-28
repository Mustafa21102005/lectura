@extends('layouts.dashboard')

@section('title', 'My Students')

@section('page_header', 'My Students')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">My Students table</h6>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">
                        <table id="students" class="table table-bordered align-middle mb-0">
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
                                        Email
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Email Verified
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Phone Number
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="text-center">{{ $student->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $student->id) }}">
                                                {{ $student->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $student->email }}</td>
                                        <td class="text-center">
                                            @if ($student->email_verified_at)
                                                <i class="material-icons text-success">check</i>
                                            @else
                                                <i class="material-icons text-danger">close</i>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $student->phone ?? 'No phone number set' }}</td>
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

        let table = new DataTable('#students', {
            responsive: true,
            language: {
                emptyTable: "No students found."
            }
        });
    </script>
@endsection
