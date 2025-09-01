<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMake;
use Illuminate\Http\Request;

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
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::where('status', 1)->pluck('name', 'id');
        $makes = ProductMake::where('status', 1)->pluck('name', 'id');
        return view('products.add', compact('categories', 'makes'));
    }

    public function store(Request $request)
    {
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
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('status', 1)->pluck('name', 'id');
        $makes = ProductMake::where('status', 1)->pluck('name', 'id');
        return view('products.edit', compact('product', 'categories', 'makes'));
    }

    public function update(Request $request, Product $product)
    {
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
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
