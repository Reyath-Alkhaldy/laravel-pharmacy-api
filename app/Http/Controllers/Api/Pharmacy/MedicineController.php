<?php

namespace App\Http\Controllers\Api\Pharmacy;

// use App\Http\Requests\MedicineRequest;
use App\Http\Requests\MedicineRequest;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $id = $request->input('pharmacy_id');
        $id =  Auth::guard('sanctum')->id();

        $sub_category_id = $request->input('sub_category_id');
        $search =  $request->input('search');
        $medicines = Medicine::where('sub_category_id', $sub_category_id)->where('pharmacy_id', $id)->when($search, function ($query) use ($search) {
            $query->where('name_ar', 'like', "%{$search}%")
                ->orWhere('name_en', 'like', "%{$search}%");
        })
            ->paginate(15);

        $medicines = collect($medicines)->except('links');
        return response()->json([
            'status' => 'success',
            'count' => $medicines->count(),
            'data' => $medicines
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineRequest $request)
    {
        $dataValidated = $request->validated();
        $dataValidated['pharmacy_id'] = Auth::guard('sanctum')->id();
        try {
            $medicine = Medicine::create($dataValidated);
            return response()->json([
                'status' => 'success',
                'message' => 'medicine was success created',
                'medicine' => $medicine,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'medicine was invalid created',
                'medicine' => $medicine,
            ]);
        }
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
