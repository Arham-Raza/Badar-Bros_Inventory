@extends('layouts.master')

@section('content')
    @php
        // Payment terms for dropdown
        $paymentTerms = [
            'cash' => 'Cash',
            'cheque' => 'Cheque',
            'po' => 'PO',
            'online_transfer' => 'Online Transfer',
        ];
    @endphp
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Receipt</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('receipts.index') }}">Receipts</a></li>
                        <li class="breadcrumb-item">Edit</li>
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="card-body" method="POST" action="{{ route('receipts.update', $receipt->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card stretch stretch-full">
                                <div class="card-body lead-status">
                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 fw-bold me-4">
                                            <span class="mb-2 d-block">Edit Receipt :</span>
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="my-2 col-md-4">
                                            <label class="fw-semibold">SI #</label>
                                            <input type="text" class="form-control"
                                                value="{{ $receipt->transaction_no }}" readonly>
                                        </div>
                                        <div class="my-2 col-md-4">
                                            <label class="fw-semibold">Customer</label>
                                            <input type="text" class="form-control"
                                                value="{{ $receipt->counterparty->name ?? '' }}" readonly>
                                        </div>
                                        <div class="my-2 col-md-4">
                                            <label class="fw-semibold">Account</label>
                                            <input type="text" class="form-control"
                                                value="{{ $receipt->account->name ?? '' }}" readonly>
                                        </div>
                                        <div class="my-2 col-md-4">
                                            <label class="fw-semibold">Amount</label>
                                            <input type="number" step="0.01" min="1" name="amount"
                                                class="form-control" value="{{ $receipt->amount }}" required>
                                        </div>
                                        <div class="my-2 col-md-4">
                                            <label for="payment_term" class="fw-semibold">Payment Term</label>
                                            <select data-select2-selector="status" class="form-select" name="payment_term"
                                                id="paymentTerm" onchange="togglePaymentFields()" disabled required>
                                                @foreach ($paymentTerms as $key => $label)
                                                    <option data-bg="bg-primary" value="{{ $key }}" 
                                                        {{ $receipt->payment_term == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="my-2 col-md-4 payment-field payment-cheque" style="display:none;">
                                            <label class="fw-semibold">Cheque #:</label>
                                            <input type="text" name="cheque_no" value="{{ $receipt->cheque_no }}" class="form-control">
                                        </div>
                                        <div class="my-2 col-md-4 payment-field payment-cheque" style="display:none;">
                                            <label class="fw-semibold">Cheque Date:</label>
                                            <input type="date" name="cheque_date" value="{{ $receipt->cheque_date }}" class="form-control">
                                        </div>
                                        <div class="my-2 col-md-4 payment-field payment-po" style="display:none;">
                                            <label class="fw-semibold">PO #:</label>
                                            <input type="text" name="po_no" value="{{ $receipt->po_no }}" class="form-control">
                                        </div>
                                        <div class="my-2 col-md-4 payment-field payment-po" style="display:none;">
                                            <label class="fw-semibold">PO Date:</label>
                                            <input type="date" name="po_date" value="{{ $receipt->po_date }}" class="form-control">
                                        </div>
                                        <div class="my-2 col-md-4 payment-field payment-online_transfer"
                                            style="display:none;">
                                            <label class="fw-semibold">Online Transfer Date:</label>
                                            <input type="date" name="online_transfer_date" value="{{ $receipt->online_transfer_date }}" class="form-control">
                                        </div>
                                        <div class="my-2 col-md-4">
                                            <label class="fw-semibold">Date</label>
                                            <input type="date" name="transaction_date" class="form-control"
                                                value="{{ $receipt->transaction_date }}" required>
                                        </div>
                                        <div class="my-2 col-md-12">
                                            <label class="fw-semibold">Note</label>
                                            <textarea name="note" class="form-control" rows="2">{{ $receipt->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="ms-auto btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function filterPaymentTerms() {
            var accountSelect = document.getElementById('accountSelect');
            var paymentTerm = document.getElementById('paymentTerm');
            var selectedOption = accountSelect.options[accountSelect.selectedIndex];
            var accountType = selectedOption ? selectedOption.getAttribute('data-type') : null;

            // Reset payment term
            paymentTerm.value = '';

            // Loop through options
            for (var i = 0; i < paymentTerm.options.length; i++) {
                var opt = paymentTerm.options[i];

                if (opt.value === '') {
                    opt.disabled = false; // keep "Select" enabled
                    continue;
                }

                if (accountType === 'cash') {
                    opt.disabled = (opt.value !== 'cash'); // only allow cash
                } else if (accountType === 'bank') {
                    opt.disabled = (opt.value === 'cash'); // allow everything except cash
                } else {
                    opt.disabled = false; // allow all if no type selected
                }
            }

            togglePaymentFields();
        }

        togglePaymentFields();
        function togglePaymentFields() {
            var term = document.getElementById('paymentTerm').value;
            document.querySelectorAll('.payment-field').forEach(function(el) {
                el.style.display = 'none';
            });
            if (term === 'cheque') {
                document.querySelectorAll('.payment-cheque').forEach(function(el) {
                    el.style.display = 'block';
                });
            } else if (term === 'po') {
                document.querySelectorAll('.payment-po').forEach(function(el) {
                    el.style.display = 'block';
                });
            } else if (term === 'online_transfer') {
                document.querySelectorAll('.payment-online_transfer').forEach(function(el) {
                    el.style.display = 'block';
                });
            }
        }
    </script>
@endsection
