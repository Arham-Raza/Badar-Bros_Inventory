<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-categories-list|product-categories-create|product-categories-edit|product-categories-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-categories-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-categories-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-categories-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $categories = ProductCategory::latest()->paginate(10);
        return view('product_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('product_categories.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        ProductCategory::create($data);
        return redirect()->route('product-categories.index')->with('success', 'Category created successfully.');
    }

    public function show(ProductCategory $productCategory)
    {
        return view('product_categories.show', compact('productCategory'));
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('product_categories.edit', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $productCategory->update($data);
        return redirect()->route('product-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return redirect()->route('product-categories.index')->with('success', 'Category deleted successfully.');
    }
}
