<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\SalesMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class SalesMasterController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:sales-list|sales-create|sales-edit|sales-delete', ['only' => ['index','store']]);
         $this->middleware('permission:sales-create', ['only' => ['create','store']]);
         $this->middleware('permission:sales-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sales-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sales = SalesMaster::with('customer')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function show(SalesMaster $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function create()
    {
        $customers = Account::where('account_type', 'customer')->pluck('name', 'id');
        $products = Product::where('status', 1)
            ->where('quantity', '>', 0)
            ->get();
        // Generate transaction_no as PI-00001, PI-00002, etc.
        $last = SalesMaster::orderByDesc('id')->first();
        $nextNumber = $last ? ((int)str_replace('PI-', '', $last->transaction_no)) + 1 : 1;
        $transaction_no = 'SI-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return view('sales.add', compact('customers', 'transaction_no', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:accounts,id',
            'transaction_date' => 'required|date',
            'transaction_no' => 'required|string',
            'gross_amount' => 'required|numeric',
            'discount_percentage' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'tax_percentage' => 'nullable|numeric',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.rate' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
            'products.*.amount' => 'required|numeric',
        ]);

        $master = SalesMaster::create([
            ...$request->except('products'),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
        foreach ($request->products as $detail) {
            $master->details()->create([
                ...$detail,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            $product = Product::find($detail['product_id']);
            $product->quantity -= $detail['quantity'];
            $product->save();
        }
        return redirect()->route('sales.index')->with('success', 'Sales created successfully.');
    }

    public function edit($id)
    {
        $sale = SalesMaster::with('details')->findOrFail($id);
        $customers = Account::where('account_type', 'customer')->pluck('name', 'id');
        $products = Product::where('status', 1)
            ->where('quantity', '>', 0)
            ->get();

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:accounts,id',
            'transaction_date' => 'required|date',
            'transaction_no' => 'required|string',
            'gross_amount' => 'required|numeric',
            'discount_percentage' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'tax_percentage' => 'nullable|numeric',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.rate' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
            'products.*.amount' => 'required|numeric',
        ]);

        $master = SalesMaster::findOrFail($id);

        // update master
        $master->update([
            ...$request->except('products'),
            'updated_by' => Auth::id(),
        ]);

        // remove old details and re-insert (simplest approach)
        foreach ($master->details as $oldDetail) {
            Product::where('id', $oldDetail->product_id)
                ->increment('quantity', $oldDetail->quantity);
        }

        $master->details()->delete();

        foreach ($request->products as $detail) {
            $master->details()->create([
                ...$detail,
                'created_by' => $master->created_by, // keep original creator
                'updated_by' => Auth::id(),
            ]);
            Product::where('id', $detail['product_id'])
                ->decrement('quantity', $detail['quantity']);
        }

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }


    public function destroy(SalesMaster $sale)
    {
        foreach ($sale->details as $oldDetail) {
            Product::where('id', $oldDetail->product_id)
                ->increment('quantity', $oldDetail->quantity);
        }

        $sale->details()->delete();
        $sale->receipts()->delete();
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
