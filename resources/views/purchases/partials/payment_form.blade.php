@php
    // Payment terms for dropdown
    $paymentTerms = [
        'cash' => 'Cash',
        'cheque' => 'Cheque',
        'po' => 'PO',
        'online_transfer' => 'Online Transfer',
    ];
@endphp

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="my-2 col-md-6">
                            <label class="form-label">Vendor</label>
                            <input type="text" class="form-control" id="counterParty"
                                readonly>
                            <input type="hidden" name="counterparty_id">
                        </div>
                        <div class="my-2 col-md-6">
                            <label class="form-label">Account (Paid From)</label>
                            <select data-select2-selector="status" id="accountSelect" name="account_id"
                                class="form-select" onchange="filterPaymentTerms()" required>
                                <option value="">Select Account</option>
                                @php
                                    $accounts = \App\Models\Account::whereIn('account_type', ['cash', 'bank'])
                                        ->get();
                                @endphp
                                @foreach ($accounts as $account)
                                    <option data-bg="bg-primary" data-type="{{ $account->account_type }}"
                                        value="{{ $account->id }}">{{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="my-2 col-md-6">
                            <label for="amount" class="form-label">Amount Paid</label>
                            <input type="number" step="0.01" min="1" class="form-control" name="amount"
                                required>
                        </div>
                        <div class="my-2 col-md-6">
                            <label for="payment_date" class="form-label">Transaction Date</label>
                            <input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}"
                                required>
                        </div>
                        <div class="my-2 col-md-6">
                            <label for="payment_term" class="form-label">Payment Term</label>
                            <select data-select2-selector="status" class="form-select" name="payment_term"
                                id="paymentTerm" onchange="togglePaymentFields()" required>
                                <option value="">Select</option>
                                @foreach ($paymentTerms as $key => $label)
                                    <option data-bg="bg-primary" value="{{ $key }}">{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="my-2 col-md-6 payment-field payment-cheque" style="display:none;">
                            <label class="fw-semibold form-label">Cheque #:</label>
                            <input type="text" name="cheque_no" class="form-control">
                        </div>
                        <div class="my-2 col-md-6 payment-field payment-cheque" style="display:none;">
                            <label class="fw-semibold form-label">Cheque Date:</label>
                            <input type="date" name="cheque_date" class="form-control">
                        </div>
                        <div class="my-2 col-md-6 payment-field payment-po" style="display:none;">
                            <label class="fw-semibold form-label">PO #:</label>
                            <input type="text" name="po_no" class="form-control">
                        </div>
                        <div class="my-2 col-md-6 payment-field payment-po" style="display:none;">
                            <label class="fw-semibold form-label">PO Date:</label>
                            <input type="date" name="po_date" class="form-control">
                        </div>
                        <div class="my-2 col-md-6 payment-field payment-online_transfer" style="display:none;">
                            <label class="fw-semibold form-label">Online Transfer Date:</label>
                            <input type="date" name="online_transfer_date" class="form-control">
                        </div>
                        <div class="my-2 col-6">
                            <label for="note" class="form-label">Description / Note</label>
                            <textarea class="form-control" name="note" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
