<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $consultaions =  Consultaion::with(['user','doctor'])->filter($request->all())->latest()->paginate();
        $consultaions =  Consultation::filter($request->all())->latest()->paginate();
        $user = User::where('id', $request->input('user_id'))->first();
        $doctor = Doctor::with('specialty')->where('id', $request->input('doctor_id'))->first();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'doctor' => $doctor,
            'data' => $consultaions,
        ]);
    }
    public function doctors(Request $request)
    {
        $query =  Consultation::query();
        $doctors =  $query
            // ->filt($request->all())
            ->with('doctor')
            ->where('user_id', $request->input('user_id'))
            ->latest()
            ->paginate();
        // return $doctors;
        $data = collect($doctors->all());
        $data = $data->groupBy(function ($item) {
            return $item->doctor_id;
        });
        $data  = $data->map(function ($a) {
            return $a->first();
        });
        // return $data;
        $dd = collect();
        foreach ($data as $key => $value) {
            $dd->push($value);
        }
        // return $dd;
        $data = collect($doctors);
        $data = $data->merge(['data' => $dd]);
        $data = $data->except('links');
        // return $data;

        return response()->json([
            'status' => 'success',
            'consultations' => $data,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'type' => ['required', 'in:question,answer'],
            'text' => ['required', 'string'],
        ]);
        $consultaions =  Consultation::create([
            'user_id' => $request->input('user_id'),
            'doctor_id' => $request->input('doctor_id'),
            'type' => $request->input('type'),
            'text' => $request->input('text'),
        ]);
        $consultaions->load(['user', 'doctor']);
        return response()->json([
            'status' => 'success',
            'consultation' => $consultaions,
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
