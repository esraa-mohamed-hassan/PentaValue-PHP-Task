<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::orderBy('id','desc')->get();
        return view('images.index', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);

        Image::create([
            'path' => 'uploads/' . $imageName,
        ]);
        
            return response()->json([
                'message' => 'Image uploaded successfully.',
                'image_path' => asset('uploads/' . $imageName),
            ]);
        
     }

    public function approve(Request $request)
    {
        $image = Image::findOrFail($request->image_id);
        $image->status = 'approved';
        $image->save();

        return response()->json(['message' => 'Image approved successfully.']);
    }

    public function reject(Request $request)
    {
        $image = Image::findOrFail($request->image_id);
        $image->status = 'rejected';
        $image->save();

        return response()->json(['message' => 'Image rejected successfully.']);
    }
}
