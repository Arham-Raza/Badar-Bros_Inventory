@extends('layouts.master')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Sales</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                        <li class="breadcrumb-item">Create</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <a href="{{ route('sales.index') }}" class="d-flex align-items-center">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="card-body" method="POST" enctype="multipart/form-data"
                            action="{{ route('sales.store') }}">
                            @csrf

                            <div class="card stretch stretch-full">
                                <div class="card-body lead-status">
                                    <div class="mb-0 d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 fw-bold me-4">
                                            <span class="mb-2 d-block">Add Sale :</span>
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="my-2 col-md-3">
                                            <label class="fw-semibold">Customer:</label>
                                            <select data-select2-selector="status" name="customer_id" class="form-control"
                                                required>
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $id => $name)
                                                    <option data-bg="bg-primary" value="{{ $id }}">
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="my-2 col-md-3">
                                            <label class="fw-semibold">Transaction #:</label>
                                            <input type="text" readonly value="{{ $transaction_no }}"
                                                name="transaction_no" class="form-control" required>
                                        </div>
                                        <div class="my-2 col-md-3">
                                            <label class="fw-semibold">Transaction Date:</label>
                                            <input type="date" name="transaction_date" class="form-control" required
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="my-2 col-md-3">
                                            <label class="fw-semibold">Attachments:</label>
                                            <input type="file" name="attachments[]" class="form-control" multiple
                                                accept=".pdf,image/jpeg,image/png,image/svg+xml">
                                            <div id="attachmentPreview" class="mt-2"></div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="mb-2">Sale Details</h5>
                                    <!-- Sale Details Table -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="saleDetailsTable">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Rate</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Product rows will be appended here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="mt-2 btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#productModal">Add
                                        Product</button>
                                    <hr>
                                    <h5 class="mb-2">Amount Details</h5>
                                    <div class="row">
                                        <div class="my-2 col-md-2">
                                            <label class="fw-semibold">Gross Amount:</label>
                                            <input readonly type="number" min="0" step="0.01" name="gross_amount"
                                                class="form-control" required>
                                        </div>
                                        <div class="my-2 col-md-2">
                                            <label class="fw-semibold">Discount %:</label>
                                            <input type="number" min="0" step="0.01" name="discount_percentage"
                                                class="form-control">
                                        </div>
                                        <div class="my-2 col-md-2">
                                            <label class="fw-semibold">Discount Amount:</label>
                                            <input type="number" min="0" step="0.01" name="discount_amount"
                                                class="form-control">
                                        </div>
                                        <div class="my-2 col-md-2">
                                            <label class="fw-semibold">Tax %:</label>
                                            <input type="number" min="0" step="0.01" name="tax_percentage"
                                                class="form-control">
                                        </div>
                                        <div class="my-2 col-md-2">
                                            <label class="fw-semibold">Tax Amount:</label>
                                            <input type="number" min="0" step="0.01" name="tax_amount"
                                                class="form-control">
                                        </div>
                                        <div class="my-2 col-md-2">
                                            <label class="fw-semibold">Net Amount:</label>
                                            <input readonly type="number" min="0" step="0.01"
                                                name="net_amount" class="form-control">
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
    <div class="modal fade-scale" id="productModal" tabindex="-1" aria-labelledby="productModal" aria-hidden="true"
        data-bs-dismiss="modal">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <!--! BEGIN: [modal-header] !-->
                <form id="productForm">
                    <div class="modal-header">
                        <h2 class="mb-0 d-flex flex-column">
                            <span class="mb-1 fs-18 fw-bold">Add Product</span>
                        </h2>
                    </div>
                    <!--! BEGIN: [modal-body] !-->
                    <div class=" modal-body">
                        <div class="mb-3">
                            <label class="form-label">Product</label>
                            <select id="modalProduct" data-select2-selector="status" class="form-control" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option data-bg="bg-primary" data-name="{{ $product->name }}"
                                        data-qty="{{ $product->quantity }}" value="{{ $product->id }}">
                                        {{ $product->name }}
                                        | Weapon No :
                                        {{ $product->weapon_no }}
                                        | Qty :
                                        {{ $product->quantity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rate</label>
                            <input type="number" min="0" step="0.01" id="modalRate" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" min="1" id="modalQuantity" value="1" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" min="0" step="0.01" id="modalAmount" class="form-control"
                                required readonly>
                        </div>
                    </div>
                    <!--! BEGIN: [modal-footer] !-->
                    <div class="modal-footer d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Modal logic for sale details
        let productIdx = 0;
        const products = [];

        // Calculate amount in modal
        document.getElementById('modalRate').addEventListener('input', function() {
            const rate = parseFloat(document.getElementById('modalRate').value) || 0;
            const qty = parseFloat(document.getElementById('modalQuantity').value) || 0;
            document.getElementById('modalAmount').value = (rate * qty).toFixed(2);
        });
        document.getElementById('modalQuantity').addEventListener('input', function() {
            const rate = parseFloat(document.getElementById('modalRate').value) || 0;
            const qty = parseFloat(document.getElementById('modalQuantity').value) || 0;
            document.getElementById('modalAmount').value = (rate * qty).toFixed(2);
        });

        // Open modal
        document.addEventListener('DOMContentLoaded', function() {
            var productModal = document.getElementById('productModal');

            // when modal is about to open
            productModal.addEventListener('show.bs.modal', function() {
                // reset form
                document.getElementById('productForm').reset();

                // clear amount explicitly
                document.getElementById('modalAmount').value = '';

                // re-init select2 inside modal and reset selection
                if (window.$ && $.fn.select2) {
                    $('#modalProduct').val('').trigger('change.select2'); // reset selected option
                } else {
                    // fallback: reset native select
                    document.getElementById('modalProduct').selectedIndex = 0;
                }
            });
        });

        // Add product to table

        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const productId = document.getElementById('modalProduct').value;
            const productText = document.getElementById('modalProduct').options[document.getElementById(
                'modalProduct').selectedIndex].getAttribute('data-name');
            const availableQty = parseFloat(document.getElementById('modalProduct').options[document.getElementById(
                'modalProduct').selectedIndex].getAttribute('data-qty')) || 0;
            const rate = parseFloat(document.getElementById('modalRate').value) || 0;
            const qty = parseFloat(document.getElementById('modalQuantity').value) || 0;
            const amount = (rate * qty).toFixed(2);
            if (!productId || !rate || !qty) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: `Please fill in all fields.`,
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    @php
                        session(['success' => null]);
                    @endphp
                });
                return;
            };
            if (qty > availableQty) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: `Quantity exceeds available stock. Available: ${availableQty}`,
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    @php
                        session(['success' => null]);
                    @endphp
                });
                return;
            }
            // Add to table
            const tbody = document.querySelector('#saleDetailsTable tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    ${productText}
                    <input type="hidden" name="products[${productIdx}][product_id]" value="${productId}">
                </td>
                <td>
                    ${rate}
                    <input type="hidden" name="products[${productIdx}][rate]" value="${rate}">
                </td>
                <td>
                    ${qty}
                    <input type="hidden" name="products[${productIdx}][quantity]" value="${qty}">
                </td>
                <td>
                    ${amount}
                    <input type="hidden" name="products[${productIdx}][amount]" value="${amount}">
                </td>
                <td><button type="button" class="btn btn-danger btn-sm remove-product">Remove</button></td>
            `;
            tbody.appendChild(row);
            productIdx++;
            // Update gross amount
            updateGrossAmount();
            // Hide modal
            bootstrap.Modal.getInstance(document.getElementById('productModal')).hide();
        });

        // Remove product row

        document.querySelector('#saleDetailsTable tbody').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('tr').remove();
                updateGrossAmount();
            }
        });

        function updateGrossAmount() {
            let sum = 0;
            document.querySelectorAll('#saleDetailsTable tbody tr').forEach(function(row) {
                const amountCell = row.querySelector('input[name*="[amount]"]');
                if (amountCell) {
                    sum += parseFloat(amountCell.value) || 0;
                }
            });
            const grossInput = document.querySelector('[name="gross_amount"]');
            if (grossInput) grossInput.value = sum.toFixed(2);
            // Optionally, recalculate amounts
            if (typeof calculateAmounts === 'function') calculateAmounts();
        }

        function calculateAmounts() {
            var gross = parseFloat(document.querySelector('[name="gross_amount"]').value) || 0;
            var discountPercInput = document.querySelector('[name="discount_percentage"]');
            var discountAmtInput = document.querySelector('[name="discount_amount"]');
            var taxPercInput = document.querySelector('[name="tax_percentage"]');
            var taxAmtInput = document.querySelector('[name="tax_amount"]');
            var netAmtInput = document.querySelector('[name="net_amount"]');

            var discountPerc = parseFloat(discountPercInput.value) || 0;
            var discountAmt = parseFloat(discountAmtInput.value) || 0;
            var taxPerc = parseFloat(taxPercInput.value) || 0;
            var taxAmt = parseFloat(taxAmtInput.value) || 0;

            // Determine which field is being edited
            var active = document.activeElement.name;

            // If gross changes, recalculate discount and tax amounts
            if (active === "gross_amount") {
                discountAmt = (gross * discountPerc / 100);
                discountAmtInput.value = discountAmt ? discountAmt.toFixed(2) : '';
                taxAmt = ((gross - discountAmt) * taxPerc / 100);
                taxAmtInput.value = taxAmt ? taxAmt.toFixed(2) : '';
            }

            // If discount percentage changes, update discount amount and tax
            if (active === "discount_percentage") {
                discountAmt = (gross * discountPerc / 100);
                discountAmtInput.value = discountAmt ? discountAmt.toFixed(2) : '';
                taxAmt = ((gross - discountAmt) * taxPerc / 100);
                taxAmtInput.value = taxAmt ? taxAmt.toFixed(2) : '';
            }
            // If discount amount changes, update discount percentage and tax
            else if (active === "discount_amount") {
                discountPerc = gross ? (discountAmt / gross * 100) : 0;
                discountPercInput.value = discountPerc ? discountPerc.toFixed(2) : '';
                taxAmt = ((gross - discountAmt) * taxPerc / 100);
                taxAmtInput.value = taxAmt ? taxAmt.toFixed(2) : '';
            }

            // If tax percentage changes, update tax amount
            if (active === "tax_percentage") {
                taxAmt = ((gross - discountAmt) * taxPerc / 100);
                taxAmtInput.value = taxAmt ? taxAmt.toFixed(2) : '';
            }
            // If tax amount changes, update tax percentage
            else if (active === "tax_amount") {
                taxPerc = (gross - discountAmt) ? (taxAmt / (gross - discountAmt) * 100) : 0;
                taxPercInput.value = taxPerc ? taxPerc.toFixed(2) : '';
            }

            // Always recalculate net amount
            var netAmt = gross - discountAmt + taxAmt;
            netAmtInput.value = netAmt ? netAmt.toFixed(2) : '';
        }

        // Attach events
        ['gross_amount', 'discount_percentage', 'discount_amount', 'tax_percentage', 'tax_amount'].forEach(function(name) {
            document.querySelector('[name="' + name + '"]').addEventListener('input', calculateAmounts);
        });
    </script>
@endsection
