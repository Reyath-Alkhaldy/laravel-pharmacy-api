<?php

namespace App\Http\Controllers\Api\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id =  Auth::guard('sanctum')->id();
        if (isset($id)) {
            $categories = MainCategory::whereHas('medicines', function ($q) use ($id) {
                $q->where('pharmacy_id', $id);
            })
                // ->with(['subCategories' => function ($q) use ($id) {
                //     $q->whereHas('medicines', function ($q) use ($id) {
                //         $q->where('pharmacy_id', $id);
                //     });
                // }])
                ->paginate();
        } else {
            $categories = MainCategory::with('medicines')->get();
        }
        $categories = collect($categories)->except('links');
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
