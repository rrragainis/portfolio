<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    public function index()
    {
        return response()->json(Audio::all());
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
                'original_image' => 'required|string',
                'mp3_file' => 'required|file|mimes:mp3|max:10240'
            ]);

            // Create uploads directory if it doesn't exist
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle MP3 file upload
            if ($request->hasFile('mp3_file')) {
                $mp3File = $request->file('mp3_file');
                $mp3Name = 'audio_' . time() . '.mp3';
                $mp3File->move($uploadPath, $mp3Name);
                $validated['mp3_file'] = env('APP_URL') . '/uploads/' . $mp3Name;
            } else {
                throw new \Exception('MP3 file is required');
            }

            // Handle base64 image data
            if (strpos($validated['cropped_image'], 'data:image') === 0 && strpos($validated['original_image'], 'data:image') === 0) {
                // Save cropped image
                $croppedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['cropped_image']));
                $croppedImageName = 'audio_thumb_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $croppedImageName, $croppedImageData);
                $croppedImagePath = env('APP_URL') . '/uploads/' . $croppedImageName;
                
                // Save original image
                $originalImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['original_image']));
                $originalImageName = 'audio_original_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $originalImageName, $originalImageData);
                $originalImagePath = env('APP_URL') . '/uploads/' . $originalImageName;
                
                $validated['cropped_image'] = $croppedImagePath;
                $validated['image_link'] = $originalImagePath;
            } else {
                throw new \Exception('Invalid image data format');
            }

            $audio = Audio::create($validated);
            return response()->json($audio, 201);
        } catch (\Exception $e) {
            \Log::error('Error in AudioController@store: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error creating audio entry: ' . $e->getMessage()], 500);
        }
    }

    public function show(Audio $audio)
    {
        return response()->json($audio);
    }

    public function update(Request $request, Audio $audio)
    {
        try {
            $validated = $request->validate([
                'latvian_name' => 'sometimes|required|string|max:255',
                'english_name' => 'sometimes|required|string|max:255',
                'latvian_description' => 'sometimes|required|string',
                'english_description' => 'sometimes|required|string',
                'cropped_image' => 'sometimes|required|string',
                'original_image' => 'sometimes|required|string',
                'mp3_file' => 'sometimes|required|file|mimes:mp3|max:10240'
            ]);

            // Create uploads directory if it doesn't exist
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Handle MP3 file if provided
            if ($request->hasFile('mp3_file')) {
                // Delete old MP3 if it exists
                if ($audio->mp3_file) {
                    $oldMp3Path = public_path(ltrim(parse_url($audio->mp3_file, PHP_URL_PATH), '/'));
                    if (file_exists($oldMp3Path)) {
                        @unlink($oldMp3Path);
                    }
                }

                $mp3File = $request->file('mp3_file');
                $mp3Name = 'audio_' . time() . '.mp3';
                $mp3File->move($uploadPath, $mp3Name);
                $validated['mp3_file'] = env('APP_URL') . '/uploads/' . $mp3Name;
            }

            // Handle images if provided
            if (isset($validated['cropped_image']) && isset($validated['original_image']) && 
                strpos($validated['cropped_image'], 'data:image') === 0 && 
                strpos($validated['original_image'], 'data:image') === 0) {
                
                // Delete old images if they exist
                if ($audio->cropped_image) {
                    $oldCroppedPath = public_path(ltrim(parse_url($audio->cropped_image, PHP_URL_PATH), '/'));
                    if (file_exists($oldCroppedPath)) {
                        @unlink($oldCroppedPath);
                    }
                }
                if ($audio->image_link) {
                    $oldOriginalPath = public_path(ltrim(parse_url($audio->image_link, PHP_URL_PATH), '/'));
                    if (file_exists($oldOriginalPath)) {
                        @unlink($oldOriginalPath);
                    }
                }

                // Save new cropped image
                $croppedImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['cropped_image']));
                $croppedImageName = 'audio_thumb_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $croppedImageName, $croppedImageData);
                $croppedImagePath = env('APP_URL') . '/uploads/' . $croppedImageName;
                
                // Save new original image
                $originalImageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $validated['original_image']));
                $originalImageName = 'audio_original_' . time() . '.jpg';
                file_put_contents($uploadPath . '/' . $originalImageName, $originalImageData);
                $originalImagePath = env('APP_URL') . '/uploads/' . $originalImageName;
                
                $validated['cropped_image'] = $croppedImagePath;
                $validated['image_link'] = $originalImagePath;
            } else {
                unset($validated['cropped_image']);
                unset($validated['original_image']);
            }

            $audio->update($validated);
            return response()->json($audio);
        } catch (\Exception $e) {
            \Log::error('Error in AudioController@update: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error updating audio entry: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Audio $audio)
    {
        $audio->delete();
        return response()->json(null, 204);
    }
} 