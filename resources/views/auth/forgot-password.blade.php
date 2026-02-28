@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('css')
    <style>
        .arrow-back {
            display: inline-block;
            transition: 0.3s all ease;
        }

        .arrow-back:hover {
            transform: translateX(-3px);
        }
    </style>
@endsection

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-4 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                Forgot Password
                            </h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="text-center text-sm text-gray-600">
                            Enter your email address and we will send you an email with a password reset link.
                        </p>

                        <form role="form" class="text-start" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="input-group input-group-outline my-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Send Password
                                    Reset Link</button>
                            </div>
                        </form>

                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('login') }}"
                                class="text-primary text-gradient font-weight-bold d-flex align-items-center arrow-back">
                                <i class="material-icons me-2">arrow_back</i> Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
