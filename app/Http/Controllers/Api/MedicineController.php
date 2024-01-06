<?php

namespace App\Http\Controllers\Api;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $pharmacyId = $request->input('pharmacy_id');
        // $request->input('pharmacy_id');
        $medicines = Medicine::filter($request->all())->get();
        return response()->json([
            'status' => 'success',
            'count' => $medicines->count(),
            'medicines' => $medicines]);
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
