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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
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
                        <a href="javascript:void(0);" class="btn btn-icon btn-light-brand" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne">
                            <i class="feather-bar-chart"></i>
                        </a>
                        {{-- <div class="dropdown">
                                <a class="btn btn-icon btn-light-brand" data-bs-toggle="dropdown" data-bs-offset="0, 10"
                                    data-bs-auto-close="outside">
                                    <i class="feather-filter"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-eye me-3"></i>
                                        <span>All</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-users me-3"></i>
                                        <span>Group</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-flag me-3"></i>
                                        <span>Country</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-dollar-sign me-3"></i>
                                        <span>Invoice</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-briefcase me-3"></i>
                                        <span>Project</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-user-check me-3"></i>
                                        <span>Active</span>
                                    </a>
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <i class="feather-user-minus me-3"></i>
                                        <span>Inactive</span>
                                    </a>
                                </div>
                            </div>
                        --}}
                        @can('users-create')
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Create User</span>
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="d-md-none d-flex align-items-center">
                    <a href="javascript:void(0)" class="page-header-right-open-toggle">
                        <i class="feather-align-right fs-20"></i>
                    </a>
                </div>
            </div>
        </div>
        <div id="collapseOne" class="accordion-collapse collapse page-header-collapse">
            <div class="pb-2 accordion-body">
                <div class="row">
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="gap-3 d-flex align-items-center">
                                        <div class="rounded avatar-text avatar-xl">
                                            <i class="feather-users"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="fw-bold d-block">
                                            <span class="text-truncate-1-line">Total Users</span>
                                            <span class="fs-24 fw-bolder d-block">{{ number_format($totalUsers) }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="gap-3 d-flex align-items-center">
                                        <div class="rounded avatar-text avatar-xl">
                                            <i class="feather-user-check"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="fw-bold d-block">
                                            <span class="text-truncate-1-line">Active Users</span>
                                            <span
                                                class="fs-24 fw-bolder d-block text-primary">{{ number_format($activeUsers) }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="gap-3 d-flex align-items-center">
                                        <div class="rounded avatar-text avatar-xl">
                                            <i class="feather-user-plus"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="fw-bold d-block">
                                            <span class="text-truncate-1-line">New Users</span>
                                            <span
                                                class="fs-24 fw-bolder d-block text-success">{{ number_format($newUsers) }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="gap-3 d-flex align-items-center">
                                        <div class="rounded avatar-text avatar-xl">
                                            <i class="feather-user-minus"></i>
                                        </div>
                                        <a href="javascript:void(0);" class="fw-bold d-block">
                                            <span class="text-truncate-1-line">Inactive Users</span>
                                            <span
                                                class="fs-24 fw-bolder d-block text-danger">{{ number_format($inactiveUsers) }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <table class="table table-hover datatable" id="customerList">
                                    <thead>
                                        <tr>
                                            <th class="text-start">SR #</th>
                                            <th>NAME</th>
                                            <th>EMAIL</th>
                                            <th>ROLES</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $user)
                                            <tr class="single-item">
                                                <td class="text-start">{{ ++$i }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if (!empty($user->getRoleNames()))
                                                        @foreach ($user->getRoleNames() as $v)
                                                            <label class="badge bg-primary">{{ $v }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    <label
                                                        class="badge bg-success">{{ $user->status == 1 ? 'Active' : 'Inactive' }}</label>
                                                </td>
                                                <td>
                                                    <div class="gap-2 hstack justify-content-start">
                                                        {{-- <a href="{{ route('users.show', $user->id) }}"
                                                            class="avatar-text avatar-md">
                                                            <i class="feather feather-eye"></i>
                                                        </a> --}}
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0)" class="avatar-text avatar-md"
                                                                data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                <i class="feather feather-more-horizontal"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @can('users-edit')
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('users.edit', $user->id) }}">
                                                                        <i class="feather feather-edit-3 me-3"></i>
                                                                        <span>Edit</span>
                                                                    </a>
                                                                </li>
                                                                @endcan
                                                                <li class="dropdown-divider"></li>
                                                                @can('users-delete')
                                                                <li>
                                                                    <form method="POST"
                                                                        action="{{ route('users.destroy', $user->id) }}"
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
    {{-- <script>
        $(document).ready(function() {
            $("#customerList").DataTable({
                pageLength: 10,
                lengthMenu: [10, 20, 50, 100, 200, 500],
                layout: {
                    topStart: {
                        buttons: [{
                                extend: 'copy'
                            },
                            {
                                extend: 'csv'
                            },
                            {
                                extend: 'excel'
                            },
                            {
                                extend: 'pdf'
                            },
                            {
                                extend: 'print'
                            },
                            {
                                extend: 'colvis'
                            }
                        ]
                    }
                }
            });
        });
    </script> --}}
@endsection
