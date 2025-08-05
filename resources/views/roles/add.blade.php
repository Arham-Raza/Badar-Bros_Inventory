@extends('layouts.master')

@section('content')

    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a><a
            href="{{ route('roles.index') }}" class="text-muted fw-light"> Roles /</a> Add</h4>

    <div class="card mb-4">
        <h5 class="card-header">Add Role</h5>
        <form class="card-body" method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="multicol-username" class="form-control" placeholder="Enter Name"
                            name="name" />
                        <label for="multicol-username">Role</label>
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
                            <div class="col-md-3 pt-0 p-3">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="{{ $value->id }}"
                                        id="permission-{{ $value->id }}" name="permission[{{ $value->id }}]"/>
                                    <label class="form-check-label text-capitalize">
                                        {{ ucwords(str_replace('-', ' ', $value->name)) }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <a href="{{ route('roles.index') }}" type="back" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
