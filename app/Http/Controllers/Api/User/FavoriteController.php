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
    public function index(Request $request)
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
            'medicine_id' => ['required', 'int', 'exists:medicines,id'],
            'device_id' => ['required'],
            'user_id' => ['sometimes', 'integer'],
        ]);
        $favorite = Favorite::where('medicine_id', $request->input('medicine_id'))->first();
        if (!$favorite) {
            $favorite = Favorite::create($dataValidated);
            $favorite = Favorite::where('medicine_id', $request->medicine_id)->first();
            return [
                "message" => "medicine added to favorite",
                "status" => "success",
                'favorite' => $favorite,
            ];
        }
        return [
            "message" => "الدواء مضاف مسبقا الى المفضلة",
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
