<?php

namespace App\Http\Controllers\Api\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class  SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $id = $request->input('pharmacy_id');
        $id =  Auth::guard('sanctum')->id();

        $main_category_id = $request->input('main_category_id');
        $subCategories = SubCategory::withCount(['medicines' => function ($q) use ($id) {
            $q->where('medicines.pharmacy_id', $id);
        }])
            ->whereHas('medicines', function ($q) use ($id) {
                $q->where('medicines.pharmacy_id', $id);
            })
            ->where('main_category_id', $main_category_id)->get();

        $subCategories = collect($subCategories)->except('links');
        return response()->json([
            'status' => 'success',
            'data' => $subCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subCategory = SubCategory::where('id', $id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $subCategory
        ]);
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
