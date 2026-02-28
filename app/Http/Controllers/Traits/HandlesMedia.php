<?php

namespace App\Http\Controllers\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HandlesMedia
{
    /**
     * Delete the specified media.
     */
    public function destroyMedia(Media $media)
    {
        $media->delete(); // deletes only this file
        return response()->json(['success' => true]);
    }

    /**
     * Return a temporary URL for the specified media.
     *
     * @param Media $media
     * @return \Illuminate\Http\Response
     */
    public function tempView(Media $media)
    {
        return response()->file($media->getPath(), [
            'Content-Disposition' => 'inline; filename="' . $media->file_name . '"'
        ]);
    }
}
