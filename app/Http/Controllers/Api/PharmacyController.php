<?php

namespace App\Http\Controllers\Api;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacies = Pharmacy::get();
        // $pharmacies = DB::table('main_categories')
        // // ->join('main_categories','pharmacies.id','main_categories.pharmacy_id')
        // ->join('sub_categories','main_categories.id','sub_categories.main_category_id')
        // ->join('medicines','sub_categories.id','medicines.sub_category_id')
        // ->join('pharmacies','medicines.pharmacy_id','pharmacies.id')
        // ->selectRaw('main_categories.* ')
        // ->groupBy('main_categories.id')
        // ->where('pharmacies.id',1)
        ->get();
        // ->dd();
        return response()->json([
            'status' => 'success',
            'data' => $pharmacies]);
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
    public function show(Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        //
    }
}
