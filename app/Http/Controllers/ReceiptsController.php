<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\SalesMaster;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:receipts-list|receipts-create|receipts-edit|receipts-delete', ['only' => ['index','store']]);
         $this->middleware('permission:receipts-create', ['only' => ['create','store']]);
         $this->middleware('permission:receipts-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:receipts-delete', ['only' => ['destroy']]);
    }
    /**
     * List all receipts.
     */
    public function index()
    {
        $receipts = Transaction::with(['account', 'counterparty'])
            ->where('type', 'receipt')
            ->orderByDesc('transaction_date')
            ->get();
        return view('receipts.index', compact('receipts'));
    }

    public function show()
    {
        return view('receipts.show');
    }


    function getSaleDetailAndTransaction($saleId)
    {
        $sale = \App\Models\SalesMaster::with(['details', 'customer', 'details.product', 'receipts', 'receipts.account'])->find($saleId);
        return response()->json([
            'success' => true,
            'sale' => $sale
        ]);
    }

    /**
     * Show the form for editing a receipt.
     */
    public function edit($id)
    {
        $receipt = Transaction::with(['account', 'counterparty'])->findOrFail($id);
        return view('receipts.edit', compact('receipt'));
    }

    /**
     * Update a receipt.
     */
    public function update(Request $request, $id)
    {
        $receipt = Transaction::findOrFail($id);
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string',
        ]);
        $receipt->update([
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'note' => $request->note,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('receipts.index')->with('success', 'Receipt updated successfully.');
    }
    /**
     * Show the receipt form/modal for a sale (AJAX or modal partial).
     */
    public function receiptForm(SalesMaster $sale)
    {
        $sale->load('receipts');
        return view('sales.partials.receipt_form', compact('sale'));
    }

    /**
     * Store a receipt for a sale.
     */
    public function storeReceipt(Request $request, SalesMaster $sale)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'receipt_date' => 'required|date',
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
            'sales_id' => $sale->id,
            'account_id' => $request->account_id,
            'counterparty_id' => $request->counterparty_id,
            'amount' => $request->amount,
            'transaction_date' => $request->receipt_date,
            'transaction_no' => $sale->transaction_no,
            'type' => 'receipt',
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

        return redirect()->route('sales.index')->with('success', 'Receipt recorded successfully.');
    }

    public function destroy(Transaction $receipt)
    {
        $receipt->delete();
        return redirect()->route('sales.index')->with('success', 'Receipt deleted successfully.');
    }
}
