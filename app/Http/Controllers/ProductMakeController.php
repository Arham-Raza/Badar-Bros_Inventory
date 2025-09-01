<?php

namespace App\Http\Controllers;

use App\Models\ProductMake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $makes = ProductMake::latest()->paginate(10);
        return view('product_make.index', compact('makes'));
    }

    public function create()
    {
        return view('product_make.add');
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
        ProductMake::create($data);
        return redirect()->route('product-makes.index')->with('success', 'Make created successfully.');
    }

    public function show(ProductMake $productMake)
    {
        return view('product_make.show', compact('productMake'));
    }

    public function edit(ProductMake $productMake)
    {
        return view('product_make.edit', compact('productMake'));
    }

    public function update(Request $request, ProductMake $productMake)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $productMake->update($data);
        return redirect()->route('product-makes.index')->with('success', 'Make updated successfully.');
    }

    public function destroy(ProductMake $productMake)
    {
        $productMake->delete();
        return redirect()->route('product-makes.index')->with('success', 'Make deleted successfully.');
    }
}
