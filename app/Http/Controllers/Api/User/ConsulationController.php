<?php
namespace App\Http\Controllers\Api\User;

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
    public function index(Request $request)
    {
        $consultaions =  Consultaion::filter($request->all())->latest()->paginate();
        return response()->json([
            'status' => 'success',
            'data' => $consultaions,
        ]);
    }
    public function doctors(Request $request)
    {
        
    }
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
