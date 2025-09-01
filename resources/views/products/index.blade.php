
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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item">Products</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    @can('products-create')
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="feather-plus me-2"></i>
                            <span>Create Product</span>
                        </a>
                    @endcan
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
                                <table class="table table-hover datatable" id="productList">
                                    <thead>
                                        <tr>
                                            <th class="text-start">SR #</th>
                                            <th>NAME</th>
                                            <th>WEAPON NO</th>
                                            <th>CATEGORY</th>
                                            <th>PRICE</th>
                                            <th>QUANTITY</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            <tr class="single-item">
                                                <td class="text-start">{{ ($products->currentPage() - 1) * $products->perPage() + $key + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->weapon_no }}</td>
                                                <td>{{ $product->category ? $product->category->name : '-' }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>
                                                    <label class="badge bg-success">{{ $product->status == 1 ? 'Active' : 'Inactive' }}</label>
                                                </td>
                                                <td>
                                                    <div class="gap-2 hstack justify-content-start">
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0)" class="avatar-text avatar-md"
                                                                data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                <i class="feather feather-more-horizontal"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @can('products-edit')
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('products.edit', $product->id) }}">
                                                                        <i class="feather feather-edit-3 me-3"></i>
                                                                        <span>Edit</span>
                                                                    </a>
                                                                </li>
                                                                @endcan
                                                                <li class="dropdown-divider"></li>
                                                                @can('products-delete')
                                                                <li>
                                                                    <form method="POST"
                                                                        action="{{ route('products.destroy', $product->id) }}"
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
                                {{ $products->links() }}
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
