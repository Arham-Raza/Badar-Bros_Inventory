@extends('layouts.master')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Product Categories</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Product Categories</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    @can('product-categories-create')
                        <a href="{{ route('product-categories.create') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Create Category</span>
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
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ $category->created_at }}</td>
                                            <td>{{ $category->updated_at }}</td>
                                            <td>
                                                <div class="gap-2 hstack justify-content-start">
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0)" class="avatar-text avatar-md"
                                                            data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                            <i class="feather feather-more-horizontal"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            @can('product-categories-edit')
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('product-categories.edit', $category->id) }}">
                                                                    <i class="feather feather-edit-3 me-3"></i>
                                                                    <span>Edit</span>
                                                                </a>
                                                            </li>
                                                            @endcan
                                                            <li class="dropdown-divider"></li>
                                                            @can('product-categories-delete')
                                                            <li>
                                                                <form method="POST"
                                                                    action="{{ route('product-categories.destroy', $category->id) }}"
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
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
