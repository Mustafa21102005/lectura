@extends('layouts.dashboard')

@section('title', 'Users')

@section('page_header', 'Users')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Error Message --}}
            <x-error-alert class="mb-5" />

            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="float-end me-3">
                            <x-create-button href="{{ route('users.create') }}" />
                        </div>
                        <h6 class="text-white text-capitalize ps-3">Users table</h6>
                    </div>
                </div>

                <div class="card-body px-4 pb-2">
                    <div class="table-responsive p-0">

                        <table id="users" class="table table-bordered align-middle mb-0">
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
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Role
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $user->id }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.show', $user) }}">
                                                {{ $user->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">
                                            @if ($user->email_verified_at)
                                                <i class="material-icons text-success">check</i>
                                            @else
                                                <i class="material-icons text-danger">close</i>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $user->phone ?? 'No phone number set' }}</td>
                                        <td class="text-center">{{ ucfirst($user->roles->first()->name) }}</td>
                                        <td class="text-center">
                                            <x-edit-button :href="route('users.edit', $user)" />
                                            @if (Auth::user()->id !== $user->id && Auth::user()->hasRole('admin') && !$user->hasRole('parent'))
                                                <x-delete-button :action="route('users.destroy', $user)" :item="'User: ' . $user->name" :id="$user->id" />
                                            @endif
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

        let table = new DataTable('#users', {
            responsive: true,
            language: {
                emptyTable: "No users found."
            }
        });
    </script>
@endsection
