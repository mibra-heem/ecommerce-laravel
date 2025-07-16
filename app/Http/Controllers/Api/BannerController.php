<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $banners = Banner::get(['id', 'image_url', 'is_active']);

        return response()->json([
            'success' => true,
            'banners' => $banners,
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
        $rules = [
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:4096',
        ];

        $data = $request->validate($rules);

        $path = $this->uploadImage($request->file('image'), 'banner/images', );

        $banner = Banner::create(['image_url' => $path, 'link' => 'null']);

        return response()->json([
            'success' => true,
            'data' => $banner,
            'message' => 'Banner created successfully.',
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
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found.',
            ], 404);
        }

        // Normalize boolean
        $request->merge([
            'is_active' => $request->has('is_active')
                ? filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                : $banner->is_active,
        ]);

        $rules = [
            'image' => 'sometimes|mimes:jpeg,png,jpg,gif|max:4096',
            'is_active' => 'nullable|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // If image is being updated
        if ($request->hasFile('image')) {
            $this->deleteImage($banner->image_url); // or actual file path
            $imageName = $this->uploadImage($request->file('image'), 'banner/images');
            $banner->image_url = $imageName;
        }

        // Update is_active if it's different
        $banner->is_active = $request->is_active;

        $banner->save();

        return response()->json([
            'success' => true,
            'data' => $banner,
            'message' => 'Banner updated successfully.',
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
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found.',
            ], 404);
        }

        // Delete image from storage
        $this->deleteImage($banner->image_url); // assuming 'image' stores the filename

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully.',
        ], 200);
    }


}
