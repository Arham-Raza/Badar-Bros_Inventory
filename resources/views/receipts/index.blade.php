@extends('layouts.master')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Payments</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Payments</li>
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="p-0 bg-custom card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover datatable" id="receiptsList">
                                        <thead>
                                            <tr>
                                                <th>SR #</th>
                                                <th>SI #</th>
                                                <th>Customer</th>
                                                <th>Account</th>
                                                <th>Amount</th>
                                                <th>Payment Term</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($receipts as $key => $receipt)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $receipt->transaction_no }}</td>
                                                    <td>{{ $receipt->counterparty->name ?? '' }}</td>
                                                    <td>{{ $receipt->account->name ?? '' }}</td>
                                                    <td>{{ number_format($receipt->amount, 2) }}</td>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $receipt->payment_term)) }}</td>
                                                    <td>{{ $receipt->transaction_date }}</td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <a href="javascript:void(0)" class="avatar-text avatar-md"
                                                                data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                <i class="feather feather-more-horizontal"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('receipts.show', $receipt->id) }}">
                                                                        <i class="feather feather-eye me-3"></i>
                                                                        <span>Show</span>
                                                                    </a>
                                                                </li>
                                                                @can('receipts-edit')
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('receipts.edit', $receipt->id) }}">
                                                                        <i class="feather feather-edit-3 me-3"></i>
                                                                        <span>Edit</span>
                                                                    </a>
                                                                </li>
                                                                @endcan
                                                                <li class="dropdown-divider"></li>
                                                                @can('receipts-delete')
                                                                <li>
                                                                    <form method="POST"
                                                                        action="{{ route('receipts.destroy', $receipt->id) }}"
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
        </div>
    </main>
@endsection
