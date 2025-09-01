@extends('layouts.master')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Roles</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('roles') }}">Roles</a></li>
                    <li class="breadcrumb-item">Create</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <a href="{{ url('roles') }}" class="d-flex align-items-center">
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
                    <form class="card-body" method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="card stretch stretch-full">
                            <div class="card-body lead-status">
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0 fw-bold me-4">
                                        <span class="mb-2 d-block">Add Role :</span>
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="my-2 col-md-6">
                                        <label for="fullnameInput" class="fw-semibold">Name: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-user"></i></div>
                                            <input type="text" name="name" class="form-control" id="fullnameInput"
                                                placeholder="Name">
                                        </div>
                                    </div>
                                    @php
                                        // Group permissions dynamically based on the first word before the hyphen
                                        $groupedPermissions = $permission->groupBy(function ($item) {
                                            return explode('-', $item->name)[0]; // Extract the first part before the hyphen
                                        });
                                    @endphp

                                    @foreach ($groupedPermissions as $group => $permissions)
                                        <div class="bg-light-primary rounded-2">
                                            <h6 class="my-2 ms-2">{{ ucwords(str_replace('_', ' ', $group)) }}</h6>
                                        </div>
                                        <div class="row row-bordered g-0">
                                            @foreach ($permissions as $value)
                                                <div class="p-3 pt-0 col-md-3">
                                                    <div class="mt-3 form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $value->id }}" id="permission-{{ $value->id }}"
                                                            name="permission[{{ $value->id }}]" />
                                                        <label class="form-check-label text-capitalize">
                                                            {{ ucwords(str_replace('-', ' ', $value->name)) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
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

