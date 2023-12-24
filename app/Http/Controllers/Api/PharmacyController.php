<?php

namespace App\Http\Controllers\Api;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacies = Pharmacy::all();
        return $pharmacies;
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
