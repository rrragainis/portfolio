<?php

namespace App\Http\Controllers;

use App\Models\ProgrammingPicture;
use Illuminate\Http\Request;

class ProgrammingPictureController extends Controller
{
    public function index()
    {
        return response()->json(ProgrammingPicture::with('programming')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'programming_id' => 'required|exists:programmings,id',
            'image_link' => 'required|file|image|max:10240'
        ]);

        // Handle additional image upload
        if ($request->hasFile('image_link')) {
            $imageFile = $request->file('image_link');
            $imageName = $imageFile->getClientOriginalName();
            $imageFile->move(public_path(), $imageName);
            $validated['image_link'] = $imageName;
        }

        $picture = ProgrammingPicture::create($validated);
        return response()->json($picture, 201);
    }

    public function show(ProgrammingPicture $picture)
    {
        return response()->json($picture->load('programming'));
    }

    public function update(Request $request, ProgrammingPicture $picture)
    {
        $validated = $request->validate([
            'programming_id' => 'sometimes|required|exists:programmings,id',
            'image_link' => 'sometimes|required|string'
        ]);

        $picture->update($validated);
        return response()->json($picture->load('programming'));
    }

    public function destroy(ProgrammingPicture $picture)
    {
        $picture->delete();
        return response()->json(null, 204);
    }
} 