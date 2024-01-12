<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $spaceImages = Image::where('category', 'space')->get();
        // dd($spaceImages);

        return view('form', ['spaceImages'=> $spaceImages]);
    }

    public function upload(Request $request)
    {
        $file = $request->file('image');  // Make sure this matches the key in formData.append('image', selectedFile);
        
        if (!$file) {
            return response()->json(['error' => 'No file provided.'], 400);
        }

        if ($request->category == 'space') {
            try {
                $folder = 'quiz';
                $fileName = $file->getClientOriginalName();
                // dd($fileName);
                // $sanitizedFileName = $this->sanitizeFileName($fileName);
                // $filePath = "{$folder}/{$sanitizedFileName}";
    
                
                // $storeFile = $file->storeAs(
                    //     $folder,
                    //     $fileName,
                    //     'digitalocean'
                    // );
                    
                $storeFile = Storage::disk('digitalocean')->putFileAs($folder, $file, $fileName, 'public');
                $fileName = basename($storeFile);

                Image::create([
                    'name' => $fileName,
                    'category' => $request->category,
                ]);
                
                // dd($fileName);
                return response()->json(['message' => 'File uploaded successfully', 'data' => $fileName]);
            } catch (RequestException $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        } else {
            try {
                // dd($folder);
                // $fileName = $file->getClientOriginalName();
                // $sanitizedFileName = $this->sanitizeFileName($fileName);
                // $filePath = "{$folder}/{$sanitizedFileName}";
    
                
                $path = Storage::disk('block')->put('', $file);
                
                Image::create([
                    'name' => $path,
                    'category' => $request->category,
                ]);
                return response()->json(['message' => 'File uploaded successfully', 'data' => $path]);
            } catch (RequestException $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
  
    }
}