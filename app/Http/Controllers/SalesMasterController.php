<?php




namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Product;
use App\Models\SalesMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

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
        try {
            $sales = SalesMaster::with('customer')->latest()->paginate(10);
            return view('sales.index', compact('sales'));
        } catch (\Throwable $e) {
            Log::error('SalesMasterController@index error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load sales.');
        }
    }

    public function show(SalesMaster $sale)
    {
        try {
            return view('sales.show', compact('sale'));
        } catch (\Throwable $e) {
            Log::error('SalesMasterController@show error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load sale details.');
        }
    }

    public function create()
    {
        try {
            $customers = Account::where('account_type', 'customer')->pluck('name', 'id');
            $products = Product::where('status', 1)
                ->where('quantity', '>', 0)
                ->get();
            $last = SalesMaster::orderByDesc('id')->first();
            $nextNumber = $last ? ((int)str_replace('SI-', '', $last->transaction_no)) + 1 : 1;
            $transaction_no = 'SI-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            return view('sales.add', compact('customers', 'transaction_no', 'products'));
        } catch (\Throwable $e) {
            Log::error('SalesMasterController@create error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load sale creation form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
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
            ];
            if ($request->hasFile('attachments')) {
                $rules['attachments.*'] = 'file|mimes:pdf,jpeg,png,svg|max:10240';
            }
            $request->validate($rules);

            $master = SalesMaster::create([
                ...$request->except(['products', 'attachments']),
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
            // Handle attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments');
                    \App\Models\Attachment::create([
                        'attachable_type' => SalesMaster::class,
                        'attachable_id' => $master->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType(),
                    ]);
                }
            }
            return redirect()->route('sales.index')->with('success', 'Sales created successfully.');
        } catch (\Throwable $e) {
            Log::error('SalesMasterController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create sale.');
        }
    }

    public function edit($id)
    {
        try {
            $sale = SalesMaster::with('details')->findOrFail($id);
            $customers = Account::where('account_type', 'customer')->pluck('name', 'id');
            $products = Product::where('status', 1)
                ->where('quantity', '>', 0)
                ->get();

            return view('sales.edit', compact('sale', 'customers', 'products'));
        } catch (\Throwable $e) {
            Log::error('SalesMasterController@edit error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load sale for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rules = [
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
            ];
            if ($request->hasFile('attachments')) {
                $rules['attachments.*'] = 'file|mimes:pdf,jpeg,png,svg|max:10240';
            }
            $request->validate($rules);

            $master = SalesMaster::findOrFail($id);

            // update master
            $master->update([
                ...$request->except(['products', 'attachments']),
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

            // Handle attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('attachments');
                    \App\Models\Attachment::create([
                        'attachable_type' => SalesMaster::class,
                        'attachable_id' => $master->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType(),
                    ]);
                }
            }

            return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
        } catch (\Throwable $e) {
            dd($e);
            Log::error('SalesMasterController@update error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to update sale.');
        }
    }

    public function destroy(SalesMaster $sale)
    {
        try {
            foreach ($sale->details as $oldDetail) {
                Product::where('id', $oldDetail->product_id)
                    ->increment('quantity', $oldDetail->quantity);
            }

            $sale->details()->delete();
            $sale->receipts()->delete();
            $sale->delete();
            return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('SalesMasterController@destroy error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete sale.');
        }
    }
}
