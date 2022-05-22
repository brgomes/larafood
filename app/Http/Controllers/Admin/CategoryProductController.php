<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function index(Product $product)
    {
        $categories = $product->categories()->paginate();

        return view('admin.pages.products.categories.index', compact('product', 'categories'));
    }

    public function products(Category $category)
    {
        $products = $category->products()->paginate();

        return view('admin.pages.categories.products', compact('category', 'products'));
    }

    public function create(Request $request, Product $product)
    {
        $filters = $request->except('_token');
        $categories = $product->categoriesAvailable($request->filter);

        return view('admin.pages.products.categories.create', compact('product', 'categories', 'filters'));
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->categories ?: [];

        if (count($data) == 0) {
            return redirect()->back()->with('warning', 'Selecione uma categoria.');
        }

        $product->categories()->attach($data);

        return redirect()->route('products.categories', $product);
    }

    public function delete(Product $product, Category $category)
    {
        $product->categories()->detach($category);

        return redirect()->route('products.categories', $product);
    }
}
