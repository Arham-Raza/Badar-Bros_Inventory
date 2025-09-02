<?php




namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:products-list|products-create|products-edit|products-delete', ['only' => ['index','store']]);
         $this->middleware('permission:products-create', ['only' => ['create','store']]);
         $this->middleware('permission:products-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:products-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        try {
            $products = Product::with('category')->latest()->paginate(10);
            return view('products.index', compact('products'));
        } catch (\Throwable $e) {
            Log::error('ProductController@index error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load products.');
        }
    }

    public function create()
    {
        try {
            $categories = ProductCategory::where('status', 1)->pluck('name', 'id');
            $makes = ProductMake::where('status', 1)->pluck('name', 'id');
            return view('products.add', compact('categories', 'makes'));
        } catch (\Throwable $e) {
            Log::error('ProductController@create error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load create product form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'status' => 'required|boolean',
                'category_id' => 'required|exists:product_categories,id',
            ]);
            Product::create($request->all());
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create product.');
        }
    }

    public function show(Product $product)
    {
        try {
            $product->load('category');
            return view('products.show', compact('product'));
        } catch (\Throwable $e) {
            Log::error('ProductController@show error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load product details.');
        }
    }

    public function edit(Product $product)
    {
        try {
            $categories = ProductCategory::where('status', 1)->pluck('name', 'id');
            $makes = ProductMake::where('status', 1)->pluck('name', 'id');
            return view('products.edit', compact('product', 'categories', 'makes'));
        } catch (\Throwable $e) {
            Log::error('ProductController@edit error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load product for editing.');
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'status' => 'required|boolean',
                'category_id' => 'required|exists:product_categories,id',
            ]);
            $product->update($request->all());
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductController@update error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to update product.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductController@destroy error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete product.');
        }
    }
}
