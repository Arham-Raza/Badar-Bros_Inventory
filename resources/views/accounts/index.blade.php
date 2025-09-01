@extends('layouts.master')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Chart of Accounts</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Chart of Accounts</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        @can('accounts-create')
                            <a href="{{ route('accounts.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Account</span>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="p-0 bg-custom card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover datatable" id="accountList">
                                        <thead>
                                            <tr>
                                                <th class="text-start">SR #</th>
                                                <th>NAME</th>
                                                <th>TYPE</th>
                                                <th>CNIC</th>
                                                <th>MOBILE 1</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accounts as $key => $account)
                                                <tr class="single-item">
                                                    <td class="text-start">
                                                        {{ ($accounts->currentPage() - 1) * $accounts->perPage() + $key + 1 }}
                                                    </td>
                                                    <td>{{ $account->name }}</td>
                                                    <td>{{ ucfirst($account->account_type) }}</td>
                                                    <td>{{ $account->cnic }}</td>
                                                    <td>{{ $account->mobile1 }}</td>
                                                    <td>
                                                        <div class="gap-2 hstack justify-content-start">
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0)" class="avatar-text avatar-md"
                                                                    data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                    <i class="feather feather-more-horizontal"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    @can('accounts-edit')
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('accounts.edit', $account->id) }}">
                                                                            <i class="feather feather-edit-3 me-3"></i>
                                                                            <span>Edit</span>
                                                                        </a>
                                                                    </li>
                                                                    @endcan
                                                                    <li class="dropdown-divider"></li>
                                                                    @can('accounts-delete')
                                                                    <li>
                                                                        <form method="POST"
                                                                            action="{{ route('accounts.destroy', $account->id) }}"
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
                                <div class="mt-3">
                                    {{ $accounts->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
