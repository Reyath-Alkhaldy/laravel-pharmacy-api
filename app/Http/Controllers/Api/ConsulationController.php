<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
      $Specialties =  Specialty::All();
        return response()->json([
            'status' => 'success',
            'data' => $Specialties,
        ]);
    }

   
    public function doctors(Request $request)
    { 
        $doctors =  Doctor::All();
        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ]);
    }

     public function consultaions()
    {
        $consultaions =  Consultaion::All();
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
