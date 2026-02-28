@extends('layouts.dashboard')

@section('title', 'Edit Grade Level')

@section('page_header', 'Edit Grade Level')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Edit Grade Level</h4>
                    </div>
                </div>
                <div class="card-body">

                    <x-error-alert />

                    <form role="form" method="POST" action="{{ route('grade-levels.update', $gradeLevel) }}">
                        @csrf
                        @method('PUT')

                        {{-- Grade Level Number --}}
                        <div class="input-group input-group-outline my-3">
                            <label for="number" class="form-label">Grade Number</label>
                            <input type="number" id="number" name="number" class="form-control" required
                                value="{{ old('number', $gradeNumber) }}">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary me-2">Update</button>
                            <x-cancel-button :route="route('grade-levels.index')" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
