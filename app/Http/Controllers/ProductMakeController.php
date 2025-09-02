<?php



namespace App\Http\Controllers;

use App\Models\ProductMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductMakeController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-makes-list|product-makes-create|product-makes-edit|product-makes-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-makes-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-makes-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-makes-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $makes = ProductMake::latest()->paginate(10);
            return view('product_make.index', compact('makes'));
        } catch (\Throwable $e) {
            Log::error('ProductMakeController@index error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load product makes.');
        }
    }

    public function create()
    {
        try {
            return view('product_make.add');
        } catch (\Throwable $e) {
            Log::error('ProductMakeController@create error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load create make form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
            ]);
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $data['updated_by'] = Auth::id();
            ProductMake::create($data);
            return redirect()->route('product-makes.index')->with('success', 'Make created successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductMakeController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create make.');
        }
    }

    public function show(ProductMake $productMake)
    {
        try {
            return view('product_make.show', compact('productMake'));
        } catch (\Throwable $e) {
            Log::error('ProductMakeController@show error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load make details.');
        }
    }

    public function edit(ProductMake $productMake)
    {
        try {
            return view('product_make.edit', compact('productMake'));
        } catch (\Throwable $e) {
            Log::error('ProductMakeController@edit error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load make for editing.');
        }
    }

    public function update(Request $request, ProductMake $productMake)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
            ]);
            $data = $request->all();
            $data['updated_by'] = Auth::id();
            $productMake->update($data);
            return redirect()->route('product-makes.index')->with('success', 'Make updated successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductMakeController@update error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to update make.');
        }
    }

    public function destroy(ProductMake $productMake)
    {
        try {
            $productMake->delete();
            return redirect()->route('product-makes.index')->with('success', 'Make deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductMakeController@destroy error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete make.');
        }
    }
}
