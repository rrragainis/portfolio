<?php

namespace App\Http\Controllers;

use App\Models\Programming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgrammingController extends Controller
{
    public function index()
    {
        try {
            return response()->json(Programming::all());
        } catch (\Exception $e) {
            Log::error('Error in ProgrammingController@index: ' . $e->getMessage());
            return response()->json(['message' => 'Error fetching programming entries'], 500);
        }
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
                $croppedImageName = 'programming_thumb_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $croppedImageName, $croppedImageData);
                $croppedImagePath = env('APP_URL') . '/uploads/' . $croppedImageName;
                
                // Save original image
                $originalImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['original_image']));
                $originalImageName = 'programming_original_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $originalImageName, $originalImageData);
                $originalImagePath = env('APP_URL') . '/uploads/' . $originalImageName;
                
                $validated['cropped_image'] = $croppedImagePath;
                $validated['image_link'] = $originalImagePath;
            } else {
                throw new \Exception('Invalid image data format');
            }

            $programming = Programming::create($validated);
            return response()->json($programming, 201);
        } catch (\Exception $e) {
            Log::error('Error in ProgrammingController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error creating programming entry: ' . $e->getMessage()], 500);
        }
    }

    public function show(Programming $programming)
    {
        try {
            return response()->json($programming);
        } catch (\Exception $e) {
            Log::error('Error in ProgrammingController@show: ' . $e->getMessage());
            return response()->json(['message' => 'Error fetching programming entry'], 500);
        }
    }

    public function update(Request $request, Programming $programming)
    {
        try {
            $validated = $request->validate([
                'latvian_name' => 'sometimes|required|string|max:255',
                'english_name' => 'sometimes|required|string|max:255',
                'latvian_description' => 'sometimes|required|string',
                'english_description' => 'sometimes|required|string',
                'cropped_image' => 'sometimes|required|string',
                'original_image' => 'sometimes|required|string'
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
                if ($programming->cropped_image) {
                    $oldCroppedPath = public_path(ltrim(parse_url($programming->cropped_image, PHP_URL_PATH), '/'));
                    if (file_exists($oldCroppedPath)) {
                        @unlink($oldCroppedPath);
                    }
                }
                if ($programming->image_link) {
                    $oldOriginalPath = public_path(ltrim(parse_url($programming->image_link, PHP_URL_PATH), '/'));
                    if (file_exists($oldOriginalPath)) {
                        @unlink($oldOriginalPath);
                    }
                }

                // Save new cropped image
                $croppedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['cropped_image']));
                $croppedImageName = 'programming_thumb_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $croppedImageName, $croppedImageData);
                $croppedImagePath = env('APP_URL') . '/uploads/' . $croppedImageName;
                
                // Save new original image
                $originalImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['original_image']));
                $originalImageName = 'programming_original_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $originalImageName, $originalImageData);
                $originalImagePath = env('APP_URL') . '/uploads/' . $originalImageName;
                
                $validated['cropped_image'] = $croppedImagePath;
                $validated['image_link'] = $originalImagePath;
            } else {
                unset($validated['cropped_image']);
                unset($validated['original_image']);
            }

            $programming->update($validated);
            return response()->json($programming);
        } catch (\Exception $e) {
            Log::error('Error in ProgrammingController@update: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error updating programming entry: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Programming $programming)
    {
        try {
            // Delete the image if it exists
            if ($programming->cropped_image) {
                $imagePath = public_path(ltrim($programming->cropped_image, '/'));
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }

            $programming->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('Error in ProgrammingController@destroy: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting programming entry: ' . $e->getMessage()], 500);
        }
    }
} 