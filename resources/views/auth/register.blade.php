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
                            <div class="text-center">
                            <img src="{{ url('/logo.png') }}" alt="" width="200" class="logo logo-lg" />
                            </div>
                            <h2 class="mb-4 fs-20 fw-bolder">Register</h2>
                            <h4 class="mb-2 fs-13 fw-bold">Register Yourself</h4>
                            {{-- <p class="fs-12 fw-medium text-muted">Let's get you all setup, so you can verify your personal
                                account and begine setting up your profile.</p> --}}
                            <form id="formAuthentication" method="POST" action="{{ route('register') }}">
                                @csrf
                                 <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Full Name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                                </div>
                                <div class="mb-3 generate-pass">
                                    <div class="input-group field">
                                        <input type="password" class="form-control password" id="newPassword"
                                            placeholder="Password Confirm" name="password" required>
                                        <div class="input-group-text c-pointer gen-pass" data-bs-toggle="tooltip"
                                            title="Generate Password"><i class="feather-hash"></i></div>
                                        <div class="input-group-text border-start bg-gray-2 c-pointer show-pass"
                                            data-bs-toggle="tooltip" title="Show/Hide Password"><i></i></div>
                                    </div>
                                    <div class="mt-2 progress-bar">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Password again" required>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-lg btn-primary w-100">Create Account</button>
                                </div>
                            </form>
                            <div class="mt-3 text-muted">
                                <span>Already have an account?</span>
                                <a href="{{ route('login') }}" class="fw-bold">Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-primary">
                        <div class="p-5 h-100 d-flex align-items-center justify-content-center">
                            <img src="{{ url('assets/images/auth/auth-user.webp') }}" alt="" class="img-fluid rounded-circle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
