<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request  $request)
    {
        $search =  $request->input('search');
        
        $doctors =  Doctor::filter($request->all())
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate();
        return response()->json([
            'status' => 'success',
            'data' => $doctors,
        ]);
    }
    public function doctors()
    {
        $currentUserId =  Auth::guard('sanctum')->id();
        $query =  Consultation::query();
        $doctors =  $query->join('doctors', 'consultations.doctor_id', 'doctors.id')
            ->with(['doctor' => function ($q) use ($currentUserId) {
                // $q->join('consultations', 'consultations.doctor_id', 'doctors.id');//->latest('consultations.created_at');
                $q->withCount(['consultations as unread_count' => function ($qq) use ($currentUserId) {
                    $qq->where('user_id', $currentUserId)->whereNull('read_at')->where('type', 'answer');
                }]);
                $q->with(['consultation' => function ($qq) use ($currentUserId) {
                    $qq->where('user_id', $currentUserId);
                }]);
            }])
            ->select("doctor_id", DB::raw(' count(*) as total'))
            ->where('user_id', $currentUserId)
            ->groupBy('consultations.doctor_id')
            ->latest('consultations.created_at')
            ->paginate();
        // return $doctors->all();
        $data = collect($doctors->all());
        $dd = collect();
        foreach ($data as   $value) {
            $dd->push($value['doctor']);
        }
        // return $dd;
        $data = collect($doctors);
        $data = $data->merge(['data' => $dd]);
        $data = $data->except('links');
        // return $data;
        return response()->json([
            'status' => 'success',
            'message' => 'success',
            'consultations' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
