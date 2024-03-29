<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            // 'device_id' => ['required'],
            'user_id' => ['sometimes', 'integer'],
        ]);
        Auth::guard('sanctum')->check() ? $dataValidated['user_id'] = Auth::guard('sanctum')->user()->id : null;
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
        $favorite = Favorite::destroy($id);

        return [
            "message" => "medicine delete from favorite",
            "status" => "success",
            'favorite' => $favorite,
        ];
    }
    public function remove()
    {   $medicine_id= request()->input('medicine_id');
        $favorite = Favorite::where('medicine_id',$medicine_id)
            ->where('user_id', Auth::guard('sanctum')->id())
            ->delete();
        // $favorite->delete();
        // $favorite->save();
        
        return [
            "message" => "medicine delete from 1 favorite $medicine_id $favorite",
            "status" => "success",
            'favorite' => $favorite,
        ];
    }
}
