<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Banner;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $banners = Banner::where('is_active', true)->get(['id', 'image_url', 'link', 'order']);

        return response()->json([
            'success' => true,
            'banners' => $banners,
        ], 200);
    }

}
