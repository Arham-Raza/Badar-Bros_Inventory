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
                        <li class="breadcrumb-item">Sales</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        @can('sales-create')
                            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Create Sale</span>
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
                                    <table class="table table-hover datatable" id="saleList">
                                        <thead>
                                            <tr>
                                                <th class="text-start">SR #</th>
                                                <th>STATUS</th>
                                                <th>TRANSACTION #</th>
                                                <th>DATE</th>
                                                <th>CUSTOMER</th>
                                                <th>NET AMOUNT</th>
                                                <th>TOTAL RECEIVED</th>
                                                <th>BALANCE</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales as $key => $sale)
                                                <tr class="single-item">
                                                    <td class="text-start">
                                                        {{ ($sales->currentPage() - 1) * $sales->perPage() + $key + 1 }}
                                                    </td>
                                                    <td>
                                                        <label
                                                            class="{{ $sale->receipts->sum('amount') == $sale->net_amount ? 'badge bg-success' : ($sale->receipts->sum('amount') < $sale->net_amount && $sale->receipts->sum('amount') != 0 ? 'badge bg-warning' : 'badge bg-danger') }}">
                                                            {{ $sale->receipts->sum('amount') == $sale->net_amount ? 'Paid' : ($sale->receipts->sum('amount') < $sale->net_amount && $sale->receipts->sum('amount') != 0 ? 'Partially Paid' : 'Unpaid') }}</label>
                                                    </td>
                                                    <td>{{ $sale->transaction_no }}</td>
                                                    <td>{{ $sale->transaction_date }}</td>
                                                    <td>{{ $sale->customer ? $sale->customer->name : '-' }}</td>
                                                    <td>{{ $sale->net_amount }}</td>
                                                    <td>
                                                        {{ number_format($sale->receipts->sum('amount'), 2) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($sale->net_amount - $sale->receipts->sum('amount'), 2) }}
                                                    </td>
                                                    <td>
                                                        <div class="gap-2 hstack justify-content-start">
                                                            <a href="javascript:void(0)" class="d-flex sale-receipt-btn"
                                                                data-id="{{ $sale->id ?? null }}"
                                                                data-transaction="{{ $sale->transaction_no }}">
                                                                <div class="avatar-text avatar-md" data-bs-toggle="tooltip"
                                                                    data-bs-trigger="hover" title="Add Receipt"><i
                                                                        class="feather feather-dollar-sign"></i></div>
                                                            </a>
                                                            <a href="javascript:void(0)" class="d-flex sale-detail-btn"
                                                                data-id="{{ $sale->id ?? null }}"
                                                                data-transaction="{{ $sale->transaction_no }}">
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
                                                                            href="{{ route('sales.show', $sale->id) }}">
                                                                            <i class="feather feather-eye me-3"></i>
                                                                            <span>Show</span>
                                                                        </a>
                                                                    </li>
                                                                    @can('sales-edit')
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('sales.edit', $sale->id) }}">
                                                                            <i class="feather feather-edit-3 me-3"></i>
                                                                            <span>Edit</span>
                                                                        </a>
                                                                    </li>
                                                                    @endcan
                                                                    <li class="dropdown-divider"></li>
                                                                    @can('sales-delete')
                                                                    <li>
                                                                        <form method="POST"
                                                                            action="{{ route('sales.destroy', $sale->id) }}"
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
    @include('sales.partials.detail_modal')
    @include('sales.partials.receipt_form')
    <script>
        document.querySelectorAll('.sale-receipt-btn, .sale-detail-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                let saleId = this.getAttribute('data-id');
                let modalType = this.classList.contains('sale-receipt-btn') ? 'receipt' : 'detail';

                fetch(`/sales/${saleId}/detail`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            let sale = data.sale;

                            if (modalType === 'detail') {
                                // Fill detail modal
                                document.querySelector('#saleDetailModal .modal-title')
                                    .textContent =
                                    `SI Detail - ${sale.transaction_no}`;

                                // Products
                                let detailRows = '';
                                if (sale.details.length > 0) {
                                    sale.details.forEach(d => {
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
                                document.querySelector('#sale-detail-body').innerHTML = detailRows;

                                // Payments
                                const csrfToken = "{{ csrf_token() }}";
                                let paymentRows = '';
                                if (sale.receipts.length > 0) {
                                    sale.receipts.forEach(p => {
                                        paymentRows += `
                                        <tr>
                                        <td>${p.transaction_date}</td>
                                        <td>${parseFloat(p.amount).toFixed(2)}</td>
                                        <td>${p.account?.name ?? ''}</td>
                                        <td class="text-capitalize">${p.payment_term.replace('_',' ')}</td>
                                        <td>
                                            <div class="d-flex ">
                                                <a href="/receipts/${p.id}/edit" class="me-2">
                                                    <div class="avatar-text avatar-md" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" title="Edit"><i class="feather feather-edit-3"></i>
                                                   </div>
                                                </a>
                                                <form method="POST" action="/receipts/${p.id}/delete" style="display:inline">
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
                                        `<tr><td colspan="4" class="text-center">No receipts found</td></tr>`;
                                }
                                document.querySelector('#sale-receipt-body').innerHTML =
                                    paymentRows;

                                let modal = new bootstrap.Modal(document.getElementById(
                                    'saleDetailModal'));
                                modal.show();

                            } else if (modalType === 'receipt') {
                                // === Receipt Modal ===
                                document.querySelector('#receiptModal form').setAttribute('action',
                                    `/sales/${sale.id}/receipt`);

                                document.querySelector('#receiptModal .modal-title').textContent =
                                    `Add Receipt for Invoice #${sale.transaction_no}`;

                                // Vendor name
                                document.querySelector('#receiptModal input[name="counterparty_id"]')
                                    .value = sale.customer_id;
                                document.querySelector('#receiptModal input[id="counterParty"]').value =
                                    sale.customer?.name ?? '';

                                // Reset fields
                                document.querySelector('#receiptModal input[name="amount"]').value = '';
                                document.querySelector('#receiptModal textarea[name="note"]').value =
                                    '';
                                document.querySelector('#receiptModal select[name="account_id"]')
                                    .value = '';
                                document.querySelector('#receiptModal select[name="payment_term"]')
                                    .value = '';
                                document.querySelectorAll('#receiptModal .payment-field').forEach(el =>
                                    el.style.display = 'none');

                                let modal = new bootstrap.Modal(document.getElementById(
                                    'receiptModal'));
                                modal.show();
                            }
                        }
                    });
            });
        });
    </script>
@endsection
