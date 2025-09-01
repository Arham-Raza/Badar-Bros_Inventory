@extends('layouts.master')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Users</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('users') }}">Users</a></li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <a href="{{ url('users') }}" class="d-flex align-items-center">
                        <i class="feather-arrow-left me-2"></i>
                        <span>Back</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->
        <!-- [ Main Content ] start -->
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <form class="card-body" method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="card stretch stretch-full">
                            <div class="card-body lead-status">
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0 fw-bold me-4">
                                        <span class="mb-2 d-block">Edit User :</span>
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="my-2 col-md-6">
                                        <label for="fullnameInput" class="fw-semibold">Name: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-user"></i></div>
                                            <input type="text" name="name" class="form-control" id="fullnameInput"
                                                placeholder="Name" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="emailInput" class="fw-semibold">Email: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-mail"></i></div>
                                            <input type="text" name="email" class="form-control" id="emailInput"
                                                placeholder="Email" value="{{ $user->email }}">
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="passwordInput" class="fw-semibold">Password: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-key"></i></div>
                                            <input type="password" name="password" class="form-control" id="passwordInput"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="confirmPasswordInput" class="fw-semibold">Confirm Password: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-key"></i></div>
                                            <input type="password" name="confirm-password" class="form-control"
                                                id="confirmPasswordInput"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="role" class="fw-semibold">Role:</label>
                                        <select multiple class="form-control" name="roles" data-select2-selector="status">
                                            @foreach ($roles as $value => $label)
                                                <option data-bg="bg-primary"
                                                    {{ isset($userRole[$value]) ? 'selected' : '' }}
                                                    value="{{ $value }}">
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="role" class="fw-semibold">Status:</label>
                                        <select class="form-control" name="status" data-select2-selector="status">
                                            <option data-bg="bg-success" {{ $user->status == 1 ? 'selected' : '' }}
                                                value="1">
                                                Active
                                            </option>
                                            <option data-bg="bg-danger" {{ $user->status == 0 ? 'selected' : '' }}
                                                value="0">
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="ms-auto btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
</main>
@endsection
