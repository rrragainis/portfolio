<?php

namespace App\Http\Controllers;

use App\Models\Photoshop;
use Illuminate\Http\Request;

class PhotoshopController extends Controller
{
    public function index()
    {
        return response()->json(Photoshop::all());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'latvian_name' => 'required|string|max:255',
                'english_name' => 'required|string|max:255',
                'latvian_description' => 'required|string',
                'english_description' => 'required|string',
                'cropped_image' => 'required|string',
                'original_image' => 'required|string'
            ]);

            // Create uploads directory if it doesn't exist
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle base64 image data
            if (strpos($validated['cropped_image'], 'data:image') === 0 && strpos($validated['original_image'], 'data:image') === 0) {
                // Save cropped image
                $croppedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['cropped_image']));
                $croppedImageName = 'photoshop_thumb_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $croppedImageName, $croppedImageData);
                $croppedImagePath = url('uploads/' . $croppedImageName);
                
                // Save original image
                $originalImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['original_image']));
                $originalImageName = 'photoshop_original_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $originalImageName, $originalImageData);
                $originalImagePath = url('uploads/' . $originalImageName);
                
                $validated['cropped_image'] = $croppedImagePath;
                $validated['image_link'] = $originalImagePath;
            } else {
                throw new \Exception('Invalid image data format');
            }

            $photoshop = Photoshop::create($validated);
            return response()->json($photoshop, 201);
        } catch (\Exception $e) {
            \Log::error('Error in PhotoshopController@store: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error creating photoshop entry: ' . $e->getMessage()], 500);
        }
    }

    public function show(Photoshop $photoshop)
    {
        return response()->json($photoshop);
    }

    public function update(Request $request, Photoshop $photoshop)
    {
        try {
            $validated = $request->validate([
                'latvian_name' => 'required|string|max:255',
                'english_name' => 'required|string|max:255',
                'latvian_description' => 'required|string',
                'english_description' => 'required|string',
                'cropped_image' => 'sometimes|string',
                'original_image' => 'sometimes|string'
            ]);

            // Create uploads directory if it doesn't exist
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle images if provided
            if (isset($validated['cropped_image']) && isset($validated['original_image']) && 
                strpos($validated['cropped_image'], 'data:image') === 0 && 
                strpos($validated['original_image'], 'data:image') === 0) {
                
                // Delete old images if they exist
                if ($photoshop->cropped_image) {
                    $oldCroppedPath = public_path(str_replace(url('/'), '', $photoshop->cropped_image));
                    if (file_exists($oldCroppedPath)) {
                        unlink($oldCroppedPath);
                    }
                }
                if ($photoshop->image_link) {
                    $oldOriginalPath = public_path(str_replace(url('/'), '', $photoshop->image_link));
                    if (file_exists($oldOriginalPath)) {
                        unlink($oldOriginalPath);
                    }
                }

                // Save new cropped image
                $croppedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['cropped_image']));
                $croppedImageName = 'photoshop_thumb_' . time() . '.webp';
                $croppedImagePath = $uploadPath . '/' . $croppedImageName;
                
                // Save the image directly without conversion
                file_put_contents($croppedImagePath, $croppedImageData);
                $croppedImageUrl = url('uploads/' . $croppedImageName);
                
                // Save new original image
                $originalImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['original_image']));
                $originalImageName = 'photoshop_original_' . time() . '.webp';
                $originalImagePath = $uploadPath . '/' . $originalImageName;
                
                // Save the image directly without conversion
                file_put_contents($originalImagePath, $originalImageData);
                $originalImageUrl = url('uploads/' . $originalImageName);
                
                $validated['cropped_image'] = $croppedImageUrl;
                $validated['image_link'] = $originalImageUrl;
            } else {
                unset($validated['cropped_image']);
                unset($validated['original_image']);
            }

            $photoshop->update($validated);
            return response()->json($photoshop);
        } catch (\Exception $e) {
            \Log::error('Error in PhotoshopController@update: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error updating photoshop entry: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Photoshop $photoshop)
    {
        $photoshop->delete();
        return response()->json(null, 204);
    }
} 