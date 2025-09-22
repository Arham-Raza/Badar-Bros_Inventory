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
use Illuminate\Support\Facades\Log;

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
        try {
            $purchases = PurchaseMaster::with('vendor')->latest()->paginate(10);
            return view('purchases.index', compact('purchases'));
        } catch (\Throwable $e) {
            Log::error('PurchaseMasterController@index error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load purchases.');
        }
    }

    public function show(PurchaseMaster $purchase)
    {
        try {
            return view('purchases.show', compact('purchase'));
        } catch (\Throwable $e) {
            Log::error('PurchaseMasterController@show error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load purchase details.');
        }
    }

    public function create()
    {
        try {
            $vendors = Account::where('account_type', 'supplier')->pluck('name', 'id');
            $products = Product::where('status', 1)->get();
            $categories = ProductCategory::where('status', 1)->pluck('name', 'id');
            $makes = ProductMake::where('status', 1)->pluck('name', 'id');
            $last = PurchaseMaster::orderByDesc('id')->first();
            $nextNumber = $last ? ((int)str_replace('PI-', '', $last->transaction_no)) + 1 : 1;
            $transaction_no = 'PI-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            return view('purchases.add', compact('vendors', 'categories', 'makes', 'transaction_no', 'products'));
        } catch (\Throwable $e) {
            Log::error('PurchaseMasterController@create error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load purchase creation form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
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
            ];
            if ($request->hasFile('attachments')) {
                $rules['attachments.*'] = 'file|mimes:pdf,jpeg,png,svg|max:10240';
            }
            $request->validate($rules);

            $master = PurchaseMaster::create([
                ...$request->except(['products', 'attachments']),
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

            // Handle attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments');
                    \App\Models\Attachment::create([
                        'attachable_type' => PurchaseMaster::class,
                        'attachable_id' => $master->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType(),
                    ]);
                }
            }

            return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
        } catch (\Throwable $e) {
            Log::error('PurchaseMasterController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create purchase.');
        }
    }

    public function edit($id)
    {
        try {
            $purchase = PurchaseMaster::with('details')->findOrFail($id);
            $vendors = Account::where('account_type', 'supplier')->pluck('name', 'id');
            $products = Product::with('category', 'make')->where('status', 1)->get();
            $categories = ProductCategory::where('status', 1)->pluck('name', 'id');
            $makes = ProductMake::where('status', 1)->pluck('name', 'id');

            return view('purchases.edit', compact('purchase', 'categories', 'makes', 'vendors', 'products'));
        } catch (\Throwable $e) {
            Log::error('PurchaseMasterController@edit error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load purchase for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rules = [
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
            ];
            if ($request->hasFile('attachments')) {
                $rules['attachments.*'] = 'file|mimes:pdf,jpeg,png,svg|max:10240';
            }
            $request->validate($rules);

            $master = PurchaseMaster::findOrFail($id);

            // update master
            $master->update([
                ...$request->except(['products', 'attachments']),
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

            // Handle attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments');
                    \App\Models\Attachment::create([
                        'attachable_type' => PurchaseMaster::class,
                        'attachable_id' => $master->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType(),
                    ]);
                }
            }

            return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
        } catch (\Throwable $e) {
            Log::error('PurchaseMasterController@update error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to update purchase.');
        }
    }

    public function destroy(PurchaseMaster $purchase)
    {
        try {
            foreach ($purchase->details as $oldDetail) {
                Product::where('id', $oldDetail->product_id)
                    ->decrement('quantity', $oldDetail->quantity);
            }

            $purchase->details()->delete();
            $purchase->payments()->delete();
            $purchase->delete();
            return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('PurchaseMasterController@destroy error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete purchase.');
        }
    }
}
