<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
     /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('image');
    }
    public function uploadImages(Request $request)
    {
        // dd($request);
        $uploadedImages = [];
    
        if ($request->hasFile('images')) {
            $images = $request->file('images');
    
            foreach ($images as $image) {
                // Generate a unique filename
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
    
                // Move the image to the desired folder (e.g., public/images)
                $image->move('images', $filename);
    
                // Store the image URL
                $uploadedImages[] = asset('images/' . $filename);
            }
        }
    
        // Return the uploaded images as a JSON response
        return response()->json(['images' => $uploadedImages]);
    }

}
