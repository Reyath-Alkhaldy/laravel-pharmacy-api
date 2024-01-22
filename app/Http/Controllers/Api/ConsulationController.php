<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialtyCollection;
use App\Models\Consultaion;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class ConsulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function spicialties()
    {
        $specialties =     Specialty::paginate();
        return response()->json([
            'status' => 'success',
            'data' => $specialties
        ]);
    }


    public function doctors(Request $request)
    {
        $doctors =  Doctor::filter($request->all())->paginate();
        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ]);
    }

    public function consultaions(Request $request)
    {
        $consultaions =  Consultaion::filter($request->all())->latest()->paginate();
        return response()->json([
            'status' => 'success',
            'data' => $consultaions,
        ]);
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
