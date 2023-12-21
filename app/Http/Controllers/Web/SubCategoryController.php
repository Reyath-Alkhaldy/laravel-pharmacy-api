<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainCategories = SubCategory::all();
        // dd($mainCategories);

        return view('web.sub.categories', compact('mainCategories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainCategories = MainCategory::all();
        // dd($mainCategories);
        return view('web.sub.create-category', compact('mainCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => "required|string|max:255",
            'name_ar' => "required|string|max:255",
            'main_category_id' => "required|integer|exists:main_categories,id"
        ]);
       $subCategory= SubCategory::create($request->all());
        return redirect()->back()->with([
            'message' => "created success new sub Category {$subCategory->name_en}      |       {$subCategory->name_ar}"
        ]); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subCategory = SubCategory::with('mainCategory')->find($id);
        return view('web.sub.show-category', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subCategory = SubCategory::with('mainCategory')->find($id);
        // dd($mainCategory);
        return view('web.sub.edit-category', compact('subCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_en' => "required|string|max:255",
            'name_ar' => "required|string|max:255",
        ]);
        $subCategory= SubCategory::findOrFail($id);
        $subCategory->update($request->all());
        return redirect('categories/sub')->with([
            'message' => "updated sub category was success {$subCategory->name_en}      |       {$subCategory->name_ar}"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
