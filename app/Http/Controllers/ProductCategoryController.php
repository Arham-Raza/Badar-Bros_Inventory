<?php




namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        try {
            $categories = ProductCategory::latest()->paginate(10);
            return view('product_categories.index', compact('categories'));
        } catch (\Throwable $e) {
            Log::error('ProductCategoryController@index error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load product categories.');
        }
    }

    public function create()
    {
        try {
            return view('product_categories.add');
        } catch (\Throwable $e) {
            Log::error('ProductCategoryController@create error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load create category form.');
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
            ProductCategory::create($data);
            return redirect()->route('product-categories.index')->with('success', 'Category created successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductCategoryController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to create category.');
        }
    }

    public function show(ProductCategory $productCategory)
    {
        try {
            return view('product_categories.show', compact('productCategory'));
        } catch (\Throwable $e) {
            Log::error('ProductCategoryController@show error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load category details.');
        }
    }

    public function edit(ProductCategory $productCategory)
    {
        try {
            return view('product_categories.edit', compact('productCategory'));
        } catch (\Throwable $e) {
            Log::error('ProductCategoryController@edit error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to load category for editing.');
        }
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
            ]);
            $data = $request->all();
            $data['updated_by'] = Auth::id();
            $productCategory->update($data);
            return redirect()->route('product-categories.index')->with('success', 'Category updated successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductCategoryController@update error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to update category.');
        }
    }

    public function destroy(ProductCategory $productCategory)
    {
        try {
            $productCategory->delete();
            return redirect()->route('product-categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('ProductCategoryController@destroy error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Failed to delete category.');
        }
    }
}
