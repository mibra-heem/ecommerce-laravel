<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function index(Request $request)
    {
        $productsData = Product::with(['images'])->get();

        $products = $productsData->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'brand' => $product->brand,
                'rating' => $product->rating,
                'description' => $product->description,
                'image_urls' => $product->images->pluck('image_url')->toArray(),
                'category_id' => $product->category_id,
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $products,
        ], 200);
    }

}
