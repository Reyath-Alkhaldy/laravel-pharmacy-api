<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = $request->input('pharmacy_id');
        if (isset($id)) {

            $categories = MainCategory::whereHas('medicines', function ($q) use ($id) {
                    $q->where('pharmacy_id', $id);
                })
                ->with(['subCategories' => function ($q) use ($id) {
                    $q->whereHas('medicines', function ($q) use ($id) {
                        $q->where('pharmacy_id', $id);
                    });
                }])

                ->get();
        } else {
            $categories = MainCategory::with('subCategories')->get();
        }
        return response()->json([
            'status' => 'success',
            'mainCategories' => $categories
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
