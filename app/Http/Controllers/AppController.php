<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function index()
    {
        $products = Product::with(['variants', 'primaryImage'])
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        return view('pages.home.index', compact('products'));
    }

    public function about()
    {
        return view('pages.home.about');
    }

    public function products(Request $request)
    {
        $query = Product::query()
            ->with(['category', 'primaryImage', 'lowestPriceVariant'])
            ->where('status', 'active');

        if ($request->filled('search')) {
            $searchTerm = strtolower($request->input('search'));

            $query->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"]);
        }

        if ($request->filled('categories') && is_array($request->input('categories'))) {
            $query->whereIn('category_id', $request->input('categories'));
        }

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if ($minPrice || $maxPrice) {
            $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                if ($minPrice) {
                    $q->where('price', '>=', $minPrice);
                }
                if ($maxPrice) {
                    $q->where('price', '<=', $maxPrice);
                }
            });
        }

        $sortOrder = $request->input('sort');
        if ($sortOrder === 'price_asc' || $sortOrder === 'price_desc') {
            $priceSubquery = ProductVariant::select('product_id', DB::raw('MIN(price) as min_price'))
                ->groupBy('product_id');

            $query->joinSub($priceSubquery, 'cheapest_variant', function ($join) {
                $join->on('products.id', '=', 'cheapest_variant.product_id');
            })
                ->orderBy('cheapest_variant.min_price', $sortOrder === 'price_asc' ? 'asc' : 'desc')
                ->select('products.*');
        } else {
            $query->latest();
        }

        $perPage = $request->input('per_page', 12);
        $products = $query->paginate($perPage);

        $categories = Category::orderBy('name')->get();
        $priceBounds = [
            'min' => floor(ProductVariant::min('price') ?? 0),
            'max' => ceil(ProductVariant::max('price') ?? 1000000),
        ];

        return view('pages.home.product', [
            'products' => $products,
            'categories' => $categories,
            'priceBounds' => $priceBounds,
        ]);
    }

    public function productDetail(Product $product)
    {
        if ($product->status !== 'active') {
            abort(404);
        }

        $product->load(['variants', 'images', 'category']);

        $relatedProducts = Product::where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('primaryImage', 'lowestPriceVariant')
            ->latest()
            ->take(4)
            ->get();

        return view('pages.home.product-detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
