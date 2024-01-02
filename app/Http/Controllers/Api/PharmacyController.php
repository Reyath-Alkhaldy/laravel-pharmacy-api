<?php

namespace App\Http\Controllers\Api;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = $request->input('id');

        $pharmacies = MainCategory::
        whereHas('medicines',function($q) use ($id) {
            $q->where('pharmacy_id',$id);
        })
        ->with(['subCategories' => function($q) use ($id){
         $q->whereHas('medicines', function($q)use ($id){
            $q->where('pharmacy_id',$id);
         });   
        } ])

        ->get();

        return view('test.test', compact('pharmacies'));

        // $medicines = Medicine::where('medicines.pharmacy_id',$id)
        //  ->groupBy('medicines.sub_category_id')
        // ->select('medicines.sub_category_id')  
        // ->get();
        // $ids=[] ;
        // foreach($medicines as $medicine){
        //     $ids[] = $medicine->sub_category_id;
        // }
        // return $ids;
       

        $pharmacies = MainCategory::
        // with(['subCategories' => function ($q)  use ($id) {
        //         $q->join('medicines', 'sub_categories.id', 'medicines.sub_category_id')
        //             ->whereHas('medicines', function ($q) use ($id) {
        //                 $q->where('pharmacy_id', $id);
        //             });
        //     }])
            // ->
            whereHas('subCategories', function ($q) use ($id) {
                $q->whereHas('medicines', function ($q) use ($id) {
                    $q->where('pharmacy_id', $id);
                });
            })
            ->get();
        return view('test.test', compact('pharmacies'));


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
