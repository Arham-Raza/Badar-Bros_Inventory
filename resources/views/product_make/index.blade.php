@extends('layouts.master')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Product Makes</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Product Makes</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    @can('product-makes-create')
                        <a href="{{ route('product-makes.create') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Create Make</span>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="bg-custom card-body">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($makes as $make)
                                        <tr>
                                            <td>{{ $make->id }}</td>
                                            <td>{{ $make->name }}</td>
                                            <td>{{ $make->status ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ $make->created_at }}</td>
                                            <td>{{ $make->updated_at }}</td>
                                            <td>
                                                <div class="gap-2 hstack justify-content-start">
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0)" class="avatar-text avatar-md"
                                                            data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                            <i class="feather feather-more-horizontal"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            @can('product-makes-edit')
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('product-makes.edit', $make->id) }}">
                                                                    <i class="feather feather-edit-3 me-3"></i>
                                                                    <span>Edit</span>
                                                                </a>
                                                            </li>
                                                            @endcan
                                                            <li class="dropdown-divider"></li>
                                                            @can('product-makes-delete')
                                                            <li>
                                                                <form method="POST"
                                                                    action="{{ route('product-makes.destroy', $make->id) }}"
                                                                    style="display:inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item delete-btn">
                                                                        <i class="feather feather-trash-2 me-3"
                                                                            aria-hidden="true"></i>
                                                                        <span>Delete</span>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            @endcan
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $makes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
