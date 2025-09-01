@extends('auth.master')
@section('content')
    <div class="px-4 py-4 d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-5">
        <div class="pt-5 mx-auto w-px-400 pt-lg-0">
            <h4 class="mb-8">Reset Password 🔒</h4>
            <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="email" id="email" class="form-control" name="email"
                                value="{{ $request->email }}" required />
                            <label for="email">Email</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <label for="password">New Password</label>
                        </div>
                        <span class="cursor-pointer input-group-text"><i class="mdi mdi-eye-off-outline"></i></span>
                    </div>
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="password" id="confirm-password" class="form-control" name="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <label for="confirm-password">Confirm Password</label>
                        </div>
                        <span class="cursor-pointer input-group-text"><i class="mdi mdi-eye-off-outline"></i></span>
                    </div>
                </div>
                <button class="mb-3 btn btn-primary d-grid w-100">Set new password</button>
            </form>
        </div>
    </div>
@endsection
