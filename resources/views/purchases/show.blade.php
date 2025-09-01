@extends('layouts.master')

@section('content')
    <style>
        @media print {

            body,
            #invoice-section,
            .invoice-container {
                background: #fff !important;
                color: #000 !important;
            }

            .card,
            .main-content,
            .nxl-content,
            .container-lg,
            .row,
            .col-lg-12 {
                background: #fff !important;
                box-shadow: none !important;
            }

            /* Hide all elements except the invoice */
            body * {
                visibility: hidden;
            }

            #invoice-section,
            #invoice-section * {
                visibility: visible;
            }

            #invoice-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100vw;
                min-height: 100vh;
                background: #fff !important;
            }
        }
    </style>
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ Main Content ] start -->
            <div class="main-content container-lg">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card invoice-container">
                            <div class="card-header">
                                <div>
                                    <h2 class="mb-0 fs-16 fw-700 text-truncate-1-line mb-sm-1">Invoice Preview</h2>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    @if (!empty($purchase->vendor->whatsapp))
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $purchase->vendor->whatsapp) }}?text={{ urlencode('Dear ' . $purchase->vendor->name . ', your invoice ' . $purchase->transaction_no . ' dated ' . ($purchase->transaction_date ? date('d M, Y', strtotime($purchase->transaction_date)) : '') . ' amounting to Rs. ' . number_format($purchase->net_amount, 2) . ' is ready.') }}"
                                            class="d-flex me-1" target="_blank">
                                            <div class="avatar-text avatar-md" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" title="Send via WhatsApp">
                                                <i class="feather feather-message-circle"></i>
                                            </div>
                                        </a>
                                    @endif
                                    <a href="javascript:void(0)" class="d-flex me-1 printBTN" onclick="printInvoice()">
                                        <div class="avatar-text avatar-md" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            title="Print Invoice">
                                            <i class="feather feather-printer"></i>
                                        </div>
                                    </a>
                                    @if ($purchase->payments && $purchase->net_amount > ($purchase->payments->sum('amount') ?? 0))
                                        <a href="javascript:void(0)" class="d-flex purchase-payment-btn"
                                            data-id="{{ $purchase->id ?? null }}"
                                            data-transaction="{{ $purchase->transaction_no }}">
                                            <div class="avatar-text avatar-md" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" title="Add Payment"><i
                                                    class="feather feather-dollar-sign"></i></div>
                                        </a>
                                    @endif
                                    <a href="{{ route('purchases.edit', $purchase->id) }}" class="d-flex me-1">
                                        <div class="avatar-text avatar-md" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            title="Edit Invoice">
                                            <i class="feather feather-edit"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="p-0 card-body" id="invoice-section">
                                <div class="text-center">
                                    <img src="{{ url('/logo.png') }}" width="300" alt="" class="p-4 logo" />
                                </div>
                                <div class="px-4 pt-4">
                                    <div class="d-sm-flex justify-content-between">
                                        <div>
                                            <div>
                                                <span class="fw-bold text-dark">Bill To:</span>
                                            </div>
                                            <div class="fs-4 fw-bolder text-primary text-uppercase">
                                                {{ $purchase->vendor->name ?? '' }}</div>
                                            <address class="text-muted w-50">
                                                {{ $purchase->vendor->address ?? '' }}
                                            </address>
                                            <address class="text-muted">
                                                <strong>Contact :</strong>
                                                {{ $purchase->vendor->mobile1 ?? '' }}<br>
                                            </address>
                                        </div>
                                        <div class="pt-3 lh-lg pt-sm-0">

                                            <h2 class="fs-4 fw-bold text-primary">
                                                {{ $purchase->transaction_no }}</h2>
                                            <label
                                                class="{{ $purchase->payments->sum('amount') == $purchase->net_amount ? 'badge bg-success' : ($purchase->payments->sum('amount') < $purchase->net_amount && $purchase->payments->sum('amount') != 0 ? 'badge bg-warning' : 'badge bg-danger') }}">
                                                {{ $purchase->payments->sum('amount') == $purchase->net_amount ? 'Paid' : ($purchase->payments->sum('amount') < $purchase->net_amount && $purchase->payments->sum('amount') != 0 ? 'Partially Paid' : 'Unpaid') }}</label>
                                            {{-- <div>
                                                <span class="fw-bold text-dark">Invoice #:</span>
                                                <span class="fw-bold text-primary"></span>
                                            </div> --}}
                                            <div>
                                                <span class="fw-bold text-dark">Date:</span>
                                                <span
                                                    class="text-muted">{{ $purchase->transaction_date ? date('d M, Y', strtotime($purchase->transaction_date)) : '' }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark">Valid Upto:</span>
                                                <span
                                                    class="text-muted">{{ $purchase->transaction_date ? date('d M, Y', strtotime('+1 year', strtotime($purchase->transaction_date))) : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-0 border-dashed">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Product</th>
                                                <th>Weapon No</th>
                                                <th>Category</th>
                                                <th>Make</th>
                                                <th>Rate</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchase->details as $index => $detail)
                                                <tr>
                                                    <td>{{ $index + 1 ?? '' }}</td>
                                                    <td>{{ $detail->product->name ?? '' }}</td>
                                                    <td>{{ $detail->product->weapon_no ?? '' }}</td>
                                                    <td>{{ $detail->product->category->name ?? '' }}</td>
                                                    <td>{{ $detail->product->make->name ?? '' }}</td>
                                                    <td>{{ number_format($detail->rate, 2) }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td class="text-dark fw-semibold">
                                                        {{ number_format($detail->amount, 2) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="7" class="bg-gray-100 fw-semibold text-dark text-lg-end">
                                                    Gross Amount</td>
                                                <td class="bg-gray-100 fw-bold text-dark">
                                                    {{ number_format($purchase->gross_amount, 2) }}</td>
                                            </tr>
                                            @if ($purchase->discount_amount > 0)
                                                <tr>
                                                    <td colspan="7"
                                                        class="bg-gray-100 fw-semibold text-dark text-lg-end">Discount</td>
                                                    <td class="bg-gray-100 fw-bold text-success">
                                                        -{{ number_format($purchase->discount_amount, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($purchase->tax_amount > 0)
                                                <tr>
                                                    <td colspan="7"
                                                        class="bg-gray-100 fw-semibold text-dark text-lg-end">Tax</td>
                                                    <td class="bg-gray-100 fw-bold text-dark">
                                                        +{{ number_format($purchase->tax_amount, 2) }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="7" class="bg-gray-100 fw-semibold text-dark text-lg-end">Net
                                                    Amount</td>
                                                <td class="bg-gray-100 fw-bolder text-dark">
                                                    {{ number_format($purchase->net_amount, 2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="bg-gray-100 fw-semibold text-dark text-lg-end">
                                                    Paid Amount</td>
                                                <td class="bg-gray-100 fw-bolder text-dark">
                                                    {{ $purchase->payments ? number_format($purchase->payments->sum('amount'), 2) : '0.00' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="bg-gray-100 fw-semibold text-dark text-lg-end">
                                                    Balance
                                                    Amount</td>
                                                <td class="bg-gray-100 fw-bolder text-dark">
                                                    {{ $purchase->payments ? number_format($purchase->net_amount - $purchase->payments->sum('amount'), 2) : '0.00' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr class="mt-0 border-dashed">
                                <div class="px-4">
                                    <div class="p-4 mt-3 justify-content-between d-flex alert alert-soft-warning-message"
                                        role="alert">
                                        <h5 class="text-nowrap">KARACHI JURISDICTION ONLY <br> E.&o.E</h5>
                                        <p class="mb-0 text-end" dir="rtl" style="unicode-bidi: bidi-override;">
                                            ١۔ وصول شدہ مال تبدیل یا واپس نہیں ہوگا۔ <br>
                                            ٢۔ سامان خریداری کے ٣ دن کی مدت میں خرابی ہونے پر مرمت کروائی جا سکتی ہے۔ <br>
                                            ٣۔ مرمت کی سہولت میں استعمال میں لائی ہوئی یا استعمال کی نشاندہی موجودہ پر عائد
                                            ہوگی۔
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </main>
    @include('purchases.partials.payment_form')
    <script>
        function printInvoice() {
            var printContents = document.getElementById('invoice-section').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // reload to restore JS events/styles
        }
        document.querySelectorAll('.purchase-payment-btn, .purchase-detail-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                let purchaseId = this.getAttribute('data-id');
                let modalType = this.classList.contains('purchase-payment-btn') ? 'payment' : 'detail';

                fetch(`/purchases/${purchaseId}/detail`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            let purchase = data.purchase;

                            if (modalType === 'detail') {
                                // Fill detail modal
                                document.querySelector('#purchaseDetailModal .modal-title')
                                    .textContent =
                                    `PI Detail - ${purchase.transaction_no}`;

                                // Products
                                let detailRows = '';
                                if (purchase.details.length > 0) {
                                    purchase.details.forEach(d => {
                                        detailRows += `
                                    <tr>
                                        <td>${d.product?.name ?? ''}</td>
                                        <td>${parseFloat(d.rate).toFixed(2)}</td>
                                        <td>${d.quantity}</td>
                                        <td>${parseFloat(d.amount).toFixed(2)}</td>
                                    </tr>`;
                                    });
                                } else {
                                    detailRows =
                                        `<tr><td colspan="4" class="text-center">No details found</td></tr>`;
                                }
                                document.querySelector('#purchase-detail-body').innerHTML = detailRows;

                                // Payments
                                const csrfToken = "{{ csrf_token() }}";
                                let paymentRows = '';
                                if (purchase.payments.length > 0) {
                                    purchase.payments.forEach(p => {
                                        paymentRows += `
                                    <tr>
                                        <td>${p.transaction_date}</td>
                                        <td>${parseFloat(p.amount).toFixed(2)}</td>
                                        <td>${p.account?.name ?? ''}</td>
                                        <td class="text-capitalize">${p.payment_term.replace('_',' ')}</td>
                                         <td>
                                            <div class="d-flex ">
                                                <a href="/payments/${p.id}/edit" class="me-2">
                                                    <div class="avatar-text avatar-md" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" title="Edit"><i class="feather feather-edit-3"></i>
                                                   </div>
                                                </a>
                                                <form method="POST" action="/payments/${p.id}/delete" style="display:inline">
                                                    <input type="hidden" name="_token" value="${csrfToken}">
                                                    <input type="hidden" name="_method" value="POST">
                                                    <button type="submit" class="delete-btn">
                                                        <div class="avatar-text avatar-md" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" title="Delete">
                                                        <i class="feather feather-trash-2" aria-hidden="true"></i>
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>`;
                                    });
                                } else {
                                    paymentRows =
                                        `<tr><td colspan="4" class="text-center">No payments found</td></tr>`;
                                }
                                document.querySelector('#purchase-payment-body').innerHTML =
                                    paymentRows;

                                let modal = new bootstrap.Modal(document.getElementById(
                                    'purchaseDetailModal'));
                                modal.show();

                            } else if (modalType === 'payment') {
                                // === Payment Modal ===
                                document.querySelector('#paymentModal form').setAttribute('action',
                                    `/purchases/${purchase.id}/pay`);

                                document.querySelector('#paymentModal .modal-title').textContent =
                                    `Add Payment for Invoice #${purchase.transaction_no}`;

                                // Vendor name
                                document.querySelector('#paymentModal input[name="counterparty_id"]')
                                    .value = purchase.vendor_id;
                                document.querySelector('#paymentModal input[id="counterParty"]').value =
                                    purchase.vendor?.name ?? '';

                                // Reset fields
                                document.querySelector('#paymentModal input[name="amount"]').value = '';
                                document.querySelector('#paymentModal textarea[name="note"]').value =
                                    '';
                                document.querySelector('#paymentModal select[name="account_id"]')
                                    .value = '';
                                document.querySelector('#paymentModal select[name="payment_term"]')
                                    .value = '';
                                document.querySelectorAll('#paymentModal .payment-field').forEach(el =>
                                    el.style.display = 'none');

                                let modal = new bootstrap.Modal(document.getElementById(
                                    'paymentModal'));
                                modal.show();
                            }
                        }
                    });
            });
        });
    </script>
@endsection
