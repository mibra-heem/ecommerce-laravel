<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function index(Request $request)
    {
        $products = Product::with('category')->cursorPaginate(10); // Adjust the number of items per page

        $productsTransformed = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'category' => $product->category->name ?? null,
                'description' => $product->descr,
            ];
        });
        $nextCursor = $products->nextCursor();
        $prevCursor = $products->previousCursor();

        return response()->json([
            'success' => true,
            'products' => $productsTransformed,
            'next_page_url' => $nextCursor ? URL::current() . '?cursor=' . $nextCursor->encode() : null,
            'prev_page_url' => $prevCursor ? URL::current() . '?cursor=' . $prevCursor->encode() : null,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * This method is unnecessary for an API as forms are handled on the frontend.
     */
    public function create()
    {
        return response()->json([
            'success' => false,
            'message' => 'Not applicable for API.',
        ], 405); // Method Not Allowed
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descr' => 'nullable|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $imageName = $this->handleImageUpload($request, 'image', 'product/images/');

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id ?? 1,
            'price' => $request->price,
            'image' => $imageName,
            'descr' => $request->descr ?? '',
        ]);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * This method is unnecessary for an API as forms are handled on the frontend.
     */
    public function edit($id)
    {
        return response()->json([
            'success' => false,
            'message' => 'Not applicable for API.',
        ], 405); // Method Not Allowed
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descr' => 'nullable|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('image')) {
            $product->image = $this->handleImageUpload($request, 'image', 'product/images/');
        }

        $product->update($request->only(['name', 'category_id', 'price', 'descr']));

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product updated successfully.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.',
        ], 200);
    }

}
