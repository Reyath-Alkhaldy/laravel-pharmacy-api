<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $files = $request->file('file');
        foreach ($files as $file) {
        $path = $file->storeAs('public/images', $file->getClientOriginalName());
        }

        return  response()
            ->json([
                'status' => 'success',
                'path' => $path,
            ]);
    }
}
