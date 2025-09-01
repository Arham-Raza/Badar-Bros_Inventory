<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\PurchaseMaster;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:payments-list|payments-create|payments-edit|payments-delete', ['only' => ['index','store']]);
         $this->middleware('permission:payments-create', ['only' => ['create','store']]);
         $this->middleware('permission:payments-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:payments-delete', ['only' => ['destroy']]);
    }
    /**
     * List all payments.
     */
    public function index()
    {
        $payments = Transaction::with(['account', 'counterparty'])
            ->where('type', 'payment')
            ->orderByDesc('transaction_date')
            ->get();
        return view('payments.index', compact('payments'));
    }

    public function show()
    {
        return view('payments.show');
    }

    function getPurchaseDetailAndTransaction($purchaseId)
    {
        $purchase = PurchaseMaster::with(['details', 'vendor', 'details.product', 'payments', 'payments.account'])->find($purchaseId);
        return response()->json([
            'success' => true,
            'purchase' => $purchase
        ]);
    }

    /**
     * Show the form for editing a payment.
     */
    public function edit($id)
    {
        $payment = Transaction::with(['account', 'counterparty'])->findOrFail($id);
        return view('payments.edit', compact('payment'));
    }

    /**
     * Update a payment.
     */
    public function update(Request $request, $id)
    {
        $payment = Transaction::findOrFail($id);
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string',
        ]);
        $payment->update([
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'note' => $request->note,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }
    /**
     * Show the payment form/modal for a purchase (AJAX or modal partial).
     */
    public function paymentForm(PurchaseMaster $purchase)
    {
        $purchase->load('payments');
        return view('purchases.partials.payment_form', compact('purchase'));
    }

    /**
     * Store a payment for a purchase.
     */
    public function storePayment(Request $request, PurchaseMaster $purchase)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_term' => 'required|in:cash,cheque,po,online_transfer',

            'cheque_no' => 'required_if:payment_term,cheque',
            'cheque_date' => 'required_if:payment_term,cheque|nullable|date',

            'po_no' => 'required_if:payment_term,po',
            'po_date' => 'required_if:payment_term,po|nullable|date',

            'online_transfer_date' => 'required_if:payment_term,online_transfer|nullable|date',

            'note' => 'nullable|string',
            'account_id' => 'required|exists:accounts,id',
            'counterparty_id' => 'required|exists:accounts,id',
        ]);


        $data = [
            'purchase_id' => $purchase->id,
            'account_id' => $request->account_id,
            'counterparty_id' => $request->counterparty_id,
            'amount' => $request->amount,
            'transaction_date' => $request->payment_date,
            'transaction_no' => $purchase->transaction_no,
            'type' => 'payment',
            'payment_term' => $request->payment_term,
            'note' => $request->note,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ];
        if ($request->payment_term === 'cheque') {
            $data['cheque_no'] = $request->cheque_no;
            $data['cheque_date'] = $request->cheque_date;
        }
        if ($request->payment_term === 'po') {
            $data['po_no'] = $request->po_no;
            $data['po_date'] = $request->po_date;
        }
        if ($request->payment_term === 'online_transfer') {
            $data['online_transfer_date'] = $request->online_transfer_date;
        }

        Transaction::create($data);

        return redirect()->route('purchases.index')->with('success', 'Payment recorded successfully.');
    }

    public function destroy(Transaction $payment)
    {
        $payment->delete();
        return redirect()->route('purchases.index')->with('success', 'Payment deleted successfully.');
    }
}
