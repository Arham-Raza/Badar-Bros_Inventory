@extends('auth.master')
@section('content')
    <div class="auth-creative-inner">
        <div class="creative-card-wrapper">
            <div class="my-4 overflow-hidden card" style="z-index: 1">
                <div class="flex-1 row g-0">
                    <div class="my-auto col-lg-6 h-100">
                        <div
                            class="p-2 bg-white shadow-lg wd-50 rounded-circle position-absolute translate-middle top-50 start-50">
                            <img src="assets/images/logo-abbr.png" alt="" class="img-fluid">
                        </div>
                        <div class="creative-card-body card-body p-sm-5">
                            <h2 class="mb-4 fs-20 fw-bolder">Reset</h2>
                            <h4 class="mb-2 fs-13 fw-bold">Reset to your username/password</h4>
                            <p class="fs-12 fw-medium text-muted">Enter your email and a reset link will sent to you, let's
                                access our the best recommendation for you.</p>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-4">
                                    <input class="form-control" name="email" placeholder="Email or Username" required>
                                </div>
                                <div class="mt-5">
                                    <button type="submit" class="btn btn-lg btn-primary w-100">Reset Now</button>
                                </div>
                            </form>
                            <div class="mt-3 text-center w-100">
                                <a href="{{ route('login') }}" class="btn btn-light-brand w-100">Back to Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-primary">
                        <div class="h-100 d-flex align-items-center justify-content-center">
                            <img src="{{ url('assets/images/auth/auth-user.webp') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
