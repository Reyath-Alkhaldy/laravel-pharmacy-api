<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search =  $request->input('search');

        $pharmacies = Pharmacy::select('id', 'name', 'email', 'address', 'phone_number', 'city_id', 'image')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            })
            ->with('city')->paginate(8);
        return response()->json([
            'status' => 'success',
            'data' => $pharmacies
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
