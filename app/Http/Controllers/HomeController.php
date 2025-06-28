<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()
            ->latest()
            ->limit(8)
            ->get();

        $categories = Product::active()
            ->distinct()
            ->pluck('category');

        return view('home', compact('featuredProducts', 'categories'));
    }

    public function catalog(Request $request)
    {
        $query = Product::active();

        if ($request->has('category') && $request->category != '') {
            $query->byCategory($request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = Product::active()
            ->distinct()
            ->pluck('category');

        return view('catalog', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if (!$product->active) {
            abort(404);
        }

        $relatedProducts = Product::active()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}