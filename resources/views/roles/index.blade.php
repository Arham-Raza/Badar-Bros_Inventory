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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Roles</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <div class="gap-2 d-flex align-items-center page-header-right-items-wrapper">
                        @can('roles-create')
                            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Role</span>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- [ page-header ] end -->
        <!-- [ Main Content ] start -->
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="p-0 bg-custom card-body">
                            <div class="table-responsive">
                                <table class="table table-hover datatable" id="rolesList">
                                    <thead>
                                        <tr>
                                            <th class="text-start">SR #</th>
                                            <th>TITLE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $key => $role)
                                            <tr class="single-item">
                                                <td class="text-start">{{ ++$i }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <div class="gap-2 hstack justify-content-start">
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0)" class="avatar-text avatar-md"
                                                                data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                <i class="feather feather-more-horizontal"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @can('roles-edit')
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('roles.edit', $role->id) }}">
                                                                        <i class="feather feather-edit-3 me-3"></i>
                                                                        <span>Edit</span>
                                                                    </a>
                                                                </li>
                                                                @endcan
                                                                <li class="dropdown-divider"></li>
                                                                @can('roles-delete')
                                                                <li>
                                                                    <form method="POST"
                                                                        action="{{ route('roles.destroy', $role->id) }}"
                                                                        style="display:inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item delete-btn">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</main>
@endsection
