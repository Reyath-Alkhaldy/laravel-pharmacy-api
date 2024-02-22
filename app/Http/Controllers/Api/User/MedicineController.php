<?php

namespace App\Http\Controllers\Api\User;

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
        // $medicines = Medicine::filter($request->all())->paginate();

        // $medicines = Medicine::
        // filter($request->all())->get();

        // return auth()->check();
        // return Auth::guest() ? 0:1;
        $medicines = Medicine:: where('count', '>', 0)

        ->filter($request->all())->get();
        // $medicines->first()->favorites->first()->pivot
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
