<?php

namespace App\Http\Controllers\Api\Pharmacy;

// use App\Http\Requests\MedicineRequest;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Models\Medicine;
use App\Trait\ImageProcessing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{
    use ImageProcessing;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
            'count' => count($medicines->get('data')) ,
            'data' => $medicines
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicineRequest $request)
    {
        $dataValidated = $request->validated();
        $dataValidated['pharmacy_id'] = Auth::guard('sanctum')->id();
        $path = $this->uploadImage($request,'medicines','pharmacy');
        if ($path) {
            $dataValidated['image'] = $path;
        }
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
    public function update(UpdateMedicineRequest $request, string $id)
    {
        $pharmacy_id = Auth::guard('sanctum')->id();
        try {
            $medicine = Medicine::where('id', $id)
                ->where('pharmacy_id', $pharmacy_id)->first();
            $medicine->update($request->validated())->save();
            return response()->json([
                'status' => 'success',
                'message' => 'medicine was success updated',
                'medicine' => $medicine,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'medicine was invalid updated',
                'medicine' => $medicine,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pharmacy_id = Auth::guard('sanctum')->id();
        if ($id) {
            $medicine = Medicine::where('id', $id)
                ->where('pharmacy_id', $pharmacy_id)
                ->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'medicine was success deleted',
                'medicine' => $medicine,
            ]);
        }
        return response()->json([
            'status' => 'invalid',
            'message' => 'medicine was invalid deleted',
            'medicine' => null,
        ]);
    }
}
