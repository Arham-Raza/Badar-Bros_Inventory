@extends('auth.master')
@section('content')
    <div class="auth-creative-inner">
        <div class="creative-card-wrapper">
            <div class="my-4 overflow-hidden card" style="z-index: 1">
                <div class="flex-1 row g-0">
                    <div class="order-1 my-auto col-lg-6 h-100 order-lg-0">
                        <div
                            class="p-2 bg-white shadow-lg wd-50 rounded-circle position-absolute translate-middle top-50 start-50 d-none d-lg-block">
                            <img src="assets/images/logo-abbr.png" alt="" class="img-fluid">
                        </div>
                        <div class="creative-card-body card-body p-sm-5">
                            <h2 class="mb-4 fs-20 fw-bolder">Login</h2>
                            <h4 class="mb-2 fs-13 fw-bold">Login to your account</h4>
                            <p class="fs-12 fw-medium text-muted">Thank you for get back <strong>Nelel</strong> web
                                applications, let's access our the best recommendation for you.</p>
                            <form class="mb-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-4">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter your email" autofocus required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="rememberMe">
                                            <label class="custom-control-label c-pointer" for="rememberMe">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('password.request') }}" class="fs-11 text-primary">Forget
                                            password?</a>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <button type="submit" class="btn btn-lg btn-primary w-100">Login</button>
                                </div>
                            </form>
                            <div class="mt-3 text-muted">
                                <span> Don't have an account?</span>
                                <a href="{{ route('register') }}" class="fw-bold">Create an Account</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 bg-primary order-0 order-lg-1">
                        <div class="h-100 d-flex align-items-center justify-content-center">
                            <img src="{{ url('assets/images/auth/auth-user.webp') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
