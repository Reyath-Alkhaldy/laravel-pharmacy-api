<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = Favorite::with('medicine')->latest()->paginate();
        $favorites = collect($favorites)->except('links');
        return  [
            "status" => "success",
            'favorites' => $favorites,
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataValidated = $request->validate([
            'medicine_id' => ['required', 'int','exists:medicines,id'],
            'device_id' => ['required'],
        ]);
        
        $favorite = Favorite::create($dataValidated);

        return [
            "message" => "medicine added to favorite",
            "status" => "success",
            'favorite' => $favorite,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
