@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-4 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                Verify Email
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 text-sm text-gray-600">
                            Thanks for signing up! Before getting started, could you verify your email address by clicking
                            on the link we just emailed to you? If you didn't receive the email, we will gladly send you
                            another.
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf

                                <div>
                                    <button type="submit" class="btn bg-gradient-primary w-100">
                                        Resend Verification Email
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="btn bg-gradient-secondary w-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
