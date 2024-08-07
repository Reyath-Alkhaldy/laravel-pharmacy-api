<?php

namespace App\Http\Controllers\Api\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainAndSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource mainCategory.
     */
    public function mainCategories()
    {
        $categories = MainCategory::whereHas('subCategories')->paginate();
        $categories = collect($categories)->except('links');
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
    /**
     * Display a listing of the resource mainCategory.
     */
    public function subCategories(Request $request)
    {
        $id =  Auth::guard('sanctum')->id();
        $categories = SubCategory::where('main_category_id', $request->input('main_category_id'))
        ->withCount(['medicines' => function ($q) use ($id) {
            $q->where('medicines.pharmacy_id', $id);
        }])
            ->get();
        // $categories = collect($categories)->except('links');
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
}
