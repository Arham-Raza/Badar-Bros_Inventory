@extends('layouts.master')

@section('content')
    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a><a
            href="{{ route('users.index') }}" class="text-muted fw-light"> Users /</a> Add</h4>

    <div class="card mb-4">
        <h5 class="card-header">Add User</h5>
        <form class="card-body" method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="multicol-username" class="form-control" placeholder="Enter Name"
                            name="name" />
                        <label for="multicol-username">Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="multicol-email" class="form-control" name="email" />
                            <label for="multicol-email">Email</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-password-toggle">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="multicol-password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-password2" />
                                <label for="multicol-password">Password</label>
                            </div>
                            <span class="input-group-text cursor-pointer" id="multicol-password2"><i
                                    class="mdi mdi-eye-off-outline"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-password-toggle">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="multicol-confirm-password" class="form-control"
                                    name="confirm-password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-confirm-password2" />
                                <label for="multicol-confirm-password">Confirm Password</label>
                            </div>
                            <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"><i
                                    class="mdi mdi-eye-off-outline"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 select2-primary">
                    <div class="form-floating form-floating-outline">
                        <select id="multicol-language" class="select2 form-select" name="roles[]" multiple>
                            @foreach ($roles as $value => $label)
                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <label for="multicol-language">Role:</label>
                    </div>
                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
            </div>
        </form>
    </div>
@endsection
