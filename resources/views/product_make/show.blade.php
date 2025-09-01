@extends('layouts.master')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Category Details</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product-categories.index') }}">Product Categories</a></li>
                    <li class="breadcrumb-item">Show</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <a href="{{ route('product-categories.index') }}" class="d-flex align-items-center">
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
                            <h5>ID: {{ $productCategory->id }}</h5>
                            <h5>Name: {{ $productCategory->name }}</h5>
                            <h5>Status: {{ $productCategory->status ? 'Active' : 'Inactive' }}</h5>
                            <h5>Created At: {{ $productCategory->created_at }}</h5>
                            <h5>Updated At: {{ $productCategory->updated_at }}</h5>
                            <h5>Created By: {{ $productCategory->created_by }}</h5>
                            <h5>Updated By: {{ $productCategory->updated_by }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
