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
        $productsData = Product::with(['category', 'images'])->get();

        $products = $productsData->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'images' => $product->images->pluck('image_url')->toArray(),
                'is_active' => $product->is_active,
                'category' => [
                    'id' => $product->category->id ?? null,
                    'name' => $product->category->name ?? null,
                ],
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $products,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Normalize boolean before validation
        $request->merge([
            'is_active' => $request->has('is_active')
                ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                : null,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create product
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        // Handle image uploads (if any)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = $this->uploadImage($image, 'product/images');

                // Save to product_images table
                $product->images()->create([
                    'image_url' => $imageName,
                    'order' => $index, // optional ordering
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
        ], 201);
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

        $product = Product::with('images')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

                // Normalize boolean
        $request->merge([
            'is_active' => $request->has('is_active')
                ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                : $product->is_active,
        ]);

        $method = $request->method();

        $rules = [
            'name' => $method === 'PATCH' ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'category_id' => $method === 'PATCH' ? 'sometimes|required|exists:categories,id' : 'required|exists:categories,id',
            'price' => $method === 'PATCH' ? 'sometimes|required|numeric|min:0' : 'required|numeric|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string|max:1200',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update fields
        $product->update($request->only([
            'name',
            'category_id',
            'price',
            'is_active',
            'description',
        ]));

        // Handle image upload
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($product->images as $image) {
                $this->deleteImage($image->image_url);
                $image->delete();
            }

            // Store new images
            foreach ($request->file('images') as $index => $uploadedImage) {
                $imagePath = $this->uploadImage($uploadedImage, 'product/images');
                $product->images()->create([
                    'image_url' => $imagePath, // Store relative path
                    'order' => $index + 1,
                ]);
            }
        }

        $product->load('images', 'category');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category_id' => $product->category_id,
                'price' => $product->price,
                'description' => $product->description,
                'is_active' => $product->is_active,
                'images' => $product->images->pluck('image_url'),
            ],
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
        $product = Product::with('images')->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        // Delete each image from public storage
        foreach ($product->images as $image) {
            $this->deleteImage($image->image_url); // Use your custom method
            $image->delete(); // Delete DB record
        }

        // Delete the product
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product and associated images deleted successfully.',
        ], 200);
    }


}
