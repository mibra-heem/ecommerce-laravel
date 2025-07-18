<?php

namespace App\Http\Controllers;

use \Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function validator(Request $request, array $rules)
    {
        return Validator::make(
            $request->all(),
            $rules
        );
    }

    protected function handleValidationFailure(Request $request, $validator)
    {
        if ($request->wantsJson()) {
            return response()->json([
                "message" => 'Validation failed',
                'error' => $validator->errors()->all(),
                'status' => false
            ], 400);
        }

        return redirect()->back()->withErrors($validator)->withInput();
    }

    protected function uploadImage(UploadedFile $file, string $imagePath): string
    {
        // Ensure directory exists
        $uploadPath = public_path("uploads/{$imagePath}");
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Generate unique file name
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move file to public/uploads/{imagePath}/
        $file->move($uploadPath, $imageName);

        // Return the public URL (e.g., /uploads/banner/images/filename.jpg)
        return "/uploads/{$imagePath}/{$imageName}";
    }

    protected function deleteImage(?string $imageUrl): void
    {
        if (!$imageUrl) {
            return; // Nothing to delete
        }

        // Convert URL to full path
        $filePath = public_path(ltrim($imageUrl, '/'));

        // Delete if exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }


    // protected function uploadImage(UploadedFile $file, string $imagePath)
    // {
    //     // stores in storage/app/public/banner/images/
    //     $path = $file->store("{$imagePath}", 'public');

    //     // returns a URL like /storage/banner/images/filename.jpg
    //     return Storage::url($path);
    // }

    // protected function deleteImage(string $imageUrl): void
    // {
    //     if (!$imageUrl) {
    //         return; // Nothing to delete
    //     }
    //     // Convert URL (/storage/banner/images/file.jpg) to storage path (banner/images/file.jpg)
    //     $relativePath = str_replace('/storage/', '', $imageUrl);

    //     if (Storage::disk('public')->exists($relativePath)) {
    //         Storage::disk('public')->delete($relativePath);
    //     }
    // }
}
