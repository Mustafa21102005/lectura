@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-4 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Validation Errors --}}
                        <x-error-alert />

                        {{-- Session Alert --}}
                        <x-primary-alert :status="session('status')" />

                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email Address --}}
                            <div @class([
                                'input-group',
                                'input-group-outline',
                                'my-3',
                                'is-focused' => old('email') || $errors->has('email'),
                                'is-filled' => old('email'),
                            ])>
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    @error('email') autofocus @enderror required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
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

                            {{-- Remember Me --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check form-switch mb-0 d-flex align-items-center">
                                    <input name="remember" class="form-check-input me-2" type="checkbox" id="remember_me">
                                    <label class="form-check-label mb-0" for="remember_me">Remember me</label>
                                </div>

                                <a href="{{ route('password.request') }}"
                                    class="text-primary text-gradient fw-bold text-decoration-none">
                                    Forgot password?
                                </a>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
