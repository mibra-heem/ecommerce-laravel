<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

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

    protected function uploadImage(Request $request, string $imagePath)
    {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path("uploads/{$imagePath}"), $imageName);

        return "/uploads/{$imagePath}{$imageName}";
    }

    protected function deleteImage($imagePath)
    {
        $file = public_path($imagePath);
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
