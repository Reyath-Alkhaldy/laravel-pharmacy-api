<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainCategories = MainCategory::all();
        return view('web.main.categories', compact('mainCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('web.main.create-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => "required|string|min:2|max:255",
            'name_ar' => "required|string|min:3|max:255",
        ]);
       $mainCategory= MainCategory::create($request->all());
        return redirect()->back()->with([
            'message' => "created success new Category {$mainCategory->name_en}      |       {$mainCategory->name_ar}"
        ]);    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mainCategory = MainCategory::with('subCategories')->find($id);
        // dd($mainCategory);
        return view('web.main.show-category', compact('mainCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mainCategory = MainCategory::with('subCategories')->find($id);
        // dd($mainCategory);
        return view('web.main.edit-category', compact('mainCategory'));
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
       $mainCategory= MainCategory::findOrFail($id);
        // dd($mainCategory);
       
       $mainCategory->update($request->all());
        return redirect('categories/main')->with([
            'message' => "updated success {$mainCategory->name_en}      |       {$mainCategory->name_ar}"
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
