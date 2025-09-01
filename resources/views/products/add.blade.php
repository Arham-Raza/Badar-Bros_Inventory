@extends('layouts.master')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Products</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item">Create</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <a href="{{ route('products.index') }}" class="d-flex align-items-center">
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
                    <form class="card-body" method="POST" action="{{ route('products.store') }}">
                        @csrf
                        <div class="card stretch stretch-full">
                            <div class="card-body lead-status">
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0 fw-bold me-4">
                                        <span class="mb-2 d-block">Add Product :</span>
                                    </h5>
                                </div>
                                <div class="row">
                                    <div class="my-2 col-md-6">
                                        <label for="nameInput" class="fw-semibold">Name: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-tag"></i></div>
                                            <input type="text" name="name" class="form-control" id="nameInput"
                                                placeholder="Product Name" required>
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="nameInput" class="fw-semibold">Weapon No: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-tag"></i></div>
                                            <input type="text" name="weapon_no" class="form-control" id="nameInput"
                                                placeholder="Weapon No" required>
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="categoryInput" class="fw-semibold">Category: </label>
                                        <select name="category_id" class="form-control" data-select2-selector="status"
                                            id="categoryInput" required>
                                            @foreach ($categories as $id => $name)
                                                <option data-bg="bg-primary" value="{{ $id }}">{{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="makeInput" class="fw-semibold">Make: </label>
                                        <select name="make_id" class="form-control" data-select2-selector="status"
                                            id="makeInput" required>
                                            @foreach ($makes as $id => $name)
                                                <option data-bg="bg-primary" value="{{ $id }}">{{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="priceInput" class="fw-semibold">Price: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-dollar-sign"></i></div>
                                            <input type="number" step="0.01" name="price" class="form-control"
                                                id="priceInput" placeholder="Price" required>
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="quantityInput" class="fw-semibold">Quantity: </label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="feather-layers"></i></div>
                                            <input type="number" name="quantity" class="form-control" id="quantityInput"
                                                placeholder="Quantity" required>
                                        </div>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="descriptionInput" class="fw-semibold">Description: </label>
                                        <textarea name="description" class="form-control" id="descriptionInput" placeholder="Description"></textarea>
                                    </div>
                                    <div class="my-2 col-md-6">
                                        <label for="role" class="fw-semibold">Status:</label>
                                        <select class="form-control" name="status" data-select2-selector="status">
                                            <option data-bg="bg-success" value="1">
                                                Active
                                            </option>
                                            <option data-bg="bg-danger" value="0">
                                                Inactive
                                            </option>
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
