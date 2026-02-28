@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-4 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                Reset Password
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form" class="text-start" method="POST" action="{{ route('password.store') }}">
                            @csrf

                            {{-- Password Reset Token --}}
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            {{-- Email Address --}}
                            <div class="input-group input-group-outline my-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ old('email', $request->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="input-group input-group-outline mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" required class="form-control">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="input-group input-group-outline mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="form-control">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
