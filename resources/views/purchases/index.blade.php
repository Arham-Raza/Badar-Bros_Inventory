@extends('layouts.master')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Purchases</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Purchases</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        @can('purchases-create')
                            <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Purchase</span>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="card stretch stretch-full">
                            <div class="p-0 bg-custom card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover datatable" id="purchaseList">
                                        <thead>
                                            <tr>
                                                <th class="text-start">SR #</th>
                                                <th>STATUS</th>
                                                <th>TRANSACTION #</th>
                                                <th>DATE</th>
                                                <th>VENDOR</th>
                                                <th>NET AMOUNT</th>
                                                <th>TOTAL PAID</th>
                                                <th>BALANCE</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchases as $key => $purchase)
                                                <tr class="single-item">
                                                    <td class="text-start">
                                                        {{ ($purchases->currentPage() - 1) * $purchases->perPage() + $key + 1 }}
                                                    </td>
                                                    <td>
                                                        <label
                                                        class="{{ $purchase->payments->sum('amount') == $purchase->net_amount ? 'badge bg-success' : ($purchase->payments->sum('amount') < $purchase->net_amount && $purchase->payments->sum('amount') != 0 ? 'badge bg-warning' : 'badge bg-danger') }}">
                                                        {{ $purchase->payments->sum('amount') == $purchase->net_amount ? 'Paid' : ($purchase->payments->sum('amount') < $purchase->net_amount && $purchase->payments->sum('amount') != 0 ? 'Partially Paid' : 'Unpaid') }}</label>
                                                    </td>
                                                    <td>{{ $purchase->transaction_no }}</td>
                                                    <td>{{ $purchase->transaction_date }}</td>
                                                    <td>{{ $purchase->vendor ? $purchase->vendor->name : '-' }}</td>
                                                    <td>{{ $purchase->net_amount }}</td>
                                                    <td>
                                                        {{ number_format($purchase->payments->sum('amount'), 2) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($purchase->net_amount - $purchase->payments->sum('amount'), 2) }}
                                                    </td>
                                                    <td>
                                                        <div class="gap-2 hstack justify-content-start">
                                                            <a href="javascript:void(0)" class="d-flex purchase-payment-btn"
                                                                data-id="{{ $purchase->id ?? null }}"
                                                                data-transaction="{{ $purchase->transaction_no }}">
                                                                <div class="avatar-text avatar-md" data-bs-toggle="tooltip"
                                                                    data-bs-trigger="hover" title="Add Payment"><i
                                                                        class="feather feather-dollar-sign"></i></div>
                                                            </a>
                                                            <a href="javascript:void(0)" class="d-flex purchase-detail-btn"
                                                                data-id="{{ $purchase->id ?? null }}"
                                                                data-transaction="{{ $purchase->transaction_no }}">
                                                                <div class="avatar-text avatar-md" data-bs-toggle="tooltip"
                                                                    data-bs-trigger="hover" title="Detail"><i
                                                                        class="feather feather-info"></i></div>
                                                            </a>
                                                            <div class="dropdown d-inline-block">
                                                                <a href="javascript:void(0)" class="avatar-text avatar-md"
                                                                    data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                    <i class="feather feather-more-horizontal"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('purchases.show', $purchase->id) }}">
                                                                            <i class="feather feather-eye me-3"></i>
                                                                            <span>Show</span>
                                                                        </a>
                                                                    </li>
                                                                    @can('purchases-edit')
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('purchases.edit', $purchase->id) }}">
                                                                            <i class="feather feather-edit-3 me-3"></i>
                                                                            <span>Edit</span>
                                                                        </a>
                                                                    </li>
                                                                    @endcan
                                                                    <li class="dropdown-divider"></li>
                                                                    @can('purchases-delete')
                                                                    <li>
                                                                        <form method="POST"
                                                                            action="{{ route('purchases.destroy', $purchase->id) }}"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('purchases.partials.detail_modal')
    @include('purchases.partials.payment_form')
    <script>
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
