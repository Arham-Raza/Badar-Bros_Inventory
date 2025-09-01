<?php

namespace App\Http\Controllers;

use App\Models\PurchaseMaster;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class PurchaseMasterController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:purchases-list|purchases-create|purchases-edit|purchases-delete', ['only' => ['index','store']]);
         $this->middleware('permission:purchases-create', ['only' => ['create','store']]);
         $this->middleware('permission:purchases-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:purchases-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $purchases = PurchaseMaster::with('vendor')->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function show(PurchaseMaster $purchase)
    {
        return view('purchases.show', compact('purchase'));
    }

    public function create()
    {
        $vendors = Account::where('account_type', 'supplier')->pluck('name', 'id');
        $products = Product::where('status', 1)->get();
        $categories = ProductCategory::where('status', 1)->pluck('name', 'id');
        $makes = ProductMake::where('status', 1)->pluck('name', 'id');
        $last = PurchaseMaster::orderByDesc('id')->first();
        $nextNumber = $last ? ((int)str_replace('PI-', '', $last->transaction_no)) + 1 : 1;
        $transaction_no = 'PI-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return view('purchases.add', compact('vendors', 'categories', 'makes', 'transaction_no', 'products'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'vendor_id' => 'required|exists:accounts,id',
            'transaction_date' => 'required|date',
            'transaction_no' => 'required|string',
            'gross_amount' => 'required|numeric',
            'discount_percentage' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'tax_percentage' => 'nullable|numeric',
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.rate' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
            'products.*.amount' => 'required|numeric',
        ]);

        $master = PurchaseMaster::create([
            ...$request->except('products'),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        foreach ($request->products as $detail) {
            $product = Product::create([
                'name' => $detail['name'],
                'weapon_no' => $detail['weapon_no'],
                'category_id' => $detail['category_id'],
                'make_id' => $detail['make_id'],
                'price' => $detail['rate'],
                'quantity' => $detail['quantity'],
                'status' => 1,
            ]);
            $detail['product_id'] = $product->id;

            $master->details()->create([
                ...$detail,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }


        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }

    public function edit($id)
    {
        $purchase = PurchaseMaster::with('details')->findOrFail($id);
        $vendors = Account::where('account_type', 'supplier')->pluck('name', 'id');
        $products = Product::with('category', 'make')->where('status', 1)->get();
        $categories = ProductCategory::where('status', 1)->pluck('name', 'id');
        $makes = ProductMake::where('status', 1)->pluck('name', 'id');

        return view('purchases.edit', compact('purchase', 'categories', 'makes', 'vendors', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vendor_id' => 'required|exists:accounts,id',
            'transaction_date' => 'required|date',
            'transaction_no' => 'required|string',
            'gross_amount' => 'required|numeric',
            'discount_percentage' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'tax_percentage' => 'nullable|numeric',
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.rate' => 'required|numeric',
            'products.*.quantity' => 'required|integer',
            'products.*.amount' => 'required|numeric',
        ]);

        $master = PurchaseMaster::findOrFail($id);

        // update master
        $master->update([
            ...$request->except('products'),
            'updated_by' => Auth::id(),
        ]);

        foreach ($master->details as $oldDetail) {
            Product::where('id', $oldDetail->product_id)->delete();
        }

        $master->details()->delete();

        foreach ($request->products as $detail) {
            $product = Product::create([
                'name' => $detail['name'],
                'weapon_no' => $detail['weapon_no'],
                'category_id' => $detail['category_id'],
                'make_id' => $detail['make_id'],
                'price' => $detail['rate'],
                'quantity' => $detail['quantity'],
                'status' => 1,
            ]);
            $detail['product_id'] = $product->id;

            $master->details()->create([
                ...$detail,
                'created_by' => $master->created_by, // keep original creator
                'updated_by' => Auth::id(),
            ]);
        }

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    }


    public function destroy(PurchaseMaster $purchase)
    {
        foreach ($purchase->details as $oldDetail) {
            Product::where('id', $oldDetail->product_id)
                ->decrement('quantity', $oldDetail->quantity);
        }

        $purchase->details()->delete();
        $purchase->payments()->delete();
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}
