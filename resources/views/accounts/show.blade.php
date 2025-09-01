@extends('layouts.master')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Account Details</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Chart of Accounts</a></li>
                    <li class="breadcrumb-item">Show</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <a href="{{ route('accounts.index') }}" class="d-flex align-items-center">
                        <i class="feather-arrow-left me-2"></i>
                        <span>Back</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>ID: {{ $account->id }}</h5>
                            <h5>Name: {{ $account->name }}</h5>
                            <h5>Type: {{ ucfirst($account->account_type) }}</h5>
                            @if(in_array($account->account_type, ['customer', 'supplier']))
                                <h5>CNIC: {{ $account->cnic }}</h5>
                                <h5>Mobile 1: {{ $account->mobile1 }}</h5>
                                <h5>Mobile 2: {{ $account->mobile2 }}</h5>
                                <h5>Whatsapp: {{ $account->whatsapp }}</h5>
                                <h5>Email: {{ $account->email }}</h5>
                                <h5>Address: {{ $account->address }}</h5>
                            @endif
                            <h5>Created At: {{ $account->created_at }}</h5>
                            <h5>Updated At: {{ $account->updated_at }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
