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
                        <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Chart of Accounts</a></li>
                        <li class="breadcrumb-item">Edit</li>
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
                        <form class="card-body" method="POST" action="{{ route('accounts.update', $account->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card stretch stretch-full">
                                <div class="card-body lead-status">
                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 fw-bold me-4">
                                            <span class="mb-2 d-block">Edit Account :</span>
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="my-2 col-md-6">
                                            <label for="typeInput" class="fw-semibold">Account Type: </label>
                                            <select name="account_type" data-select2-selector="status" class="form-control"
                                                id="typeInput" required onchange="toggleAccountFields()">
                                                <option value="">Select Type</option>
                                                @foreach ($accountTypes as $key => $label)
                                                    <option value="{{ $key }}" data-bg="bg-primary"
                                                        {{ $account->account_type == $key ? 'selected' : '' }}>
                                                        {{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="my-2 col-md-6">
                                            <label for="nameInput" class="fw-semibold">Name: </label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="feather-user"></i></div>
                                                <input type="text" name="name" class="form-control" id="nameInput"
                                                    value="{{ $account->name }}" required>
                                            </div>
                                        </div>
                                        <div id="bankFields" style="display:none;">
                                            <div class="my-2 col-md-6">
                                                <label for="ibanInput" class="fw-semibold">IBAN: </label>
                                                <input type="text" name="iban" class="form-control" id="ibanInput"
                                                    value="{{ $account->iban }}" placeholder="IBAN">
                                            </div>
                                            <div class="my-2 col-md-6">
                                                <label for="accountNumberInput" class="fw-semibold">Account Number: </label>
                                                <input type="text" name="account_number" class="form-control"
                                                    id="accountNumberInput" value="{{ $account->account_number }}"
                                                    placeholder="Account Number">
                                            </div>
                                            <div class="my-2 col-md-6">
                                                <label for="accountTitleInput" class="fw-semibold">Account Title: </label>
                                                <input type="text" name="account_title" class="form-control"
                                                    id="accountTitleInput" value="{{ $account->account_title }}"
                                                    placeholder="Account Title">
                                            </div>
                                        </div>
                                        <div id="customerSupplierFields" style="display:none;">
                                            <div class="my-2 col-md-6">
                                                <label for="cnicInput" class="fw-semibold">CNIC: </label>
                                                <input type="text" name="cnic" class="form-control" id="cnicInput"
                                                    value="{{ $account->cnic }}" placeholder="CNIC">
                                            </div>
                                            <div class="my-2 col-md-6">
                                                <label for="mobile1Input" class="fw-semibold">Mobile 1: </label>
                                                <input type="text" name="mobile1" class="form-control" id="mobile1Input"
                                                    value="{{ $account->mobile1 }}" placeholder="Mobile 1">
                                            </div>
                                            <div class="my-2 col-md-6">
                                                <label for="mobile2Input" class="fw-semibold">Mobile 2: </label>
                                                <input type="text" name="mobile2" class="form-control"
                                                    id="mobile2Input" value="{{ $account->mobile2 }}"
                                                    placeholder="Mobile 2">
                                            </div>
                                            <div class="my-2 col-md-6">
                                                <label for="whatsappInput" class="fw-semibold">Whatsapp: </label>
                                                <input type="text" name="whatsapp" class="form-control"
                                                    id="whatsappInput" value="{{ $account->whatsapp }}"
                                                    placeholder="Whatsapp">
                                            </div>
                                            <div class="my-2 col-md-6">
                                                <label for="emailInput" class="fw-semibold">Email: </label>
                                                <input type="email" name="email" class="form-control"
                                                    id="emailInput" value="{{ $account->email }}" placeholder="Email">
                                            </div>
                                            <div class="my-2 col-md-6">
                                                <label for="addressInput" class="fw-semibold">Address: </label>
                                                <textarea name="address" class="form-control" id="addressInput" placeholder="Address">{{ $account->address }}</textarea>
                                            </div>
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
        </div>
    </main>
    <script>
        function toggleAccountFields() {
            var type = document.getElementById('typeInput').value;
            var customerSupplierFields = document.getElementById('customerSupplierFields');
            var bankFields = document.getElementById('bankFields');
            if (type === 'customer' || type === 'supplier') {
                customerSupplierFields.style.display = 'flex';
                customerSupplierFields.classList.add('row');
            } else {
                customerSupplierFields.style.display = 'none';
                customerSupplierFields.classList.remove('row');
            }
            if (type === 'bank') {
                bankFields.style.display = 'flex';
                bankFields.classList.add('row');
            } else {
                bankFields.style.display = 'none';
                bankFields.classList.remove('row');
            }
        }
        // On page load, show fields if needed
        document.addEventListener('DOMContentLoaded', function() {
            toggleAccountFields();
        });
    </script>
@endsection
