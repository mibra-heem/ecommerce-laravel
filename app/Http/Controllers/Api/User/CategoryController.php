<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->get(['id', 'name', 'slug', 'parent_id', 'icon_url', 'order']);

        return response()->json([
            'success' => true,
            'categories' => $categories,
        ], 200);
    }
}
