<?php

namespace App\Trait;

use Illuminate\Support\Facades\Storage;
use Image;

trait ImageProcessing
{

    protected function uploadImage($request, $path, $disk)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        return $file->store($path, $disk);
    }


    public function saveImage($image)
    {
        // $img =Image::make($image);
    }
    public function get_mime($mime)
    {
        switch ($mime) {
            case 'image/jpg':
                $extension = "jpg";
                break;
            case 'image/png':
                $extension = "png";
                break;
            case 'image/jpeg':
                $extension = "jpeg";
                break;
            case 'image/gif':
                $extension = "gif";
                break;
            case 'image/webp':
                $extension = "webp";
                break;
            case 'image/tiff':
                $extension = "tiff";
                break;
            case 'image/svg':
                $extension = "svg";
                break;
            default:
                # code...
                break;
        }
        return $extension;
    }
}
