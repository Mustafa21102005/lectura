<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Handle the incoming request to upload a file.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 422);
        }

        try {
            $request->validate([
                'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,bmp,png,gif,mp4,webm,svg,mp3,wav,ogg,webp,mov|max:102400'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'File type not allowed or too large'], 422);
        }
        $file = $request->file('file');

        // Get file extension
        $extension = $file->getClientOriginalExtension();

        // Generate safe random name
        $fileName = uniqid() . '.' . $extension;

        $folder = uniqid() . '-' . now()->timestamp;

        $tmpPath = "uploads/tmp/{$folder}";
        Storage::disk('public')->makeDirectory($tmpPath);

        $file->storeAs($tmpPath, $fileName, 'public');

        return response()->json([
            'folder' => $folder,
            'file' => $fileName,
            'url' => Storage::disk('public')->url($tmpPath . '/' . $fileName)
        ], 200);
    }

    /**
     * Delete a folder and its contents from the public disk
     *
     * @param string $folder
     * @return \Illuminate\Http\JsonResponse
     */
    public function revert($folder)
    {
        Storage::disk('public')->deleteDirectory("uploads/tmp/{$folder}");
        return response()->json(['success' => true]);
    }
}
