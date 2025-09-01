@extends('layouts.master')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Product Makes</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product-makes.index') }}">Product Makes</a></li>
                    <li class="breadcrumb-item">Edit</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <a href="{{ route('product-makes.index') }}" class="d-flex align-items-center">
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="card-body" method="POST" action="{{ route('product-makes.update', $productMake->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="card stretch stretch-full">
                            <div class="card-body lead-status">
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0 fw-bold me-4">
                                        <span class="mb-2 d-block">Edit Make :</span>
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="my-2 col-md-6">
                                        <label for="nameInput" class="fw-semibold">Name: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-tag"></i></div>
                                            <input type="text" name="name" class="form-control" id="nameInput" value="{{ $productMake->name }}" required>
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="statusInput" class="fw-semibold">Status: </label>
                                        <select name="status" class="form-control" id="statusInput">
                                            <option value="1" {{ $productMake->status ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$productMake->status ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="ms-auto btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</main>
@endsection
