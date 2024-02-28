<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consultation\StoreConsultationRequest;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use App\Notifications\CreatedConsultationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $consultaions =  Consultation::filter($request->all())->latest()->paginate();
        $user = User::where('id',  Auth::guard('sanctum')->id())->first();
        $doctor = Doctor::with('specialty')->where('id', $request->input('doctor_id'))->first();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'doctor' => $doctor,
            'data' => $consultaions,
        ]);
    }

    
    public function marksRead(Request $request)
    {
        $currentUserId =  Auth::guard('sanctum')->id();
        $doctorId =  $request->input('doctor_id');

        $consultations =  Consultation::where('user_id', $currentUserId)
            ->where('doctor_id', $doctorId)
            ->where('type', 'answer')
            ->get();
        foreach ($consultations as   $consultation) {
            $consultation->update(['read_at' => now()]);
            // $consultations;
        }
        return response()->json([
            'status' => 'success',
            'message' => 'marks read were success',
        ]);
    }



    // public function doctors(Request $request)
    // {
    //   $currentUserId =  Auth::guard('sanctum')->id();
    //     $unreadCountPerDoctor = Doctor::
    //     with(['consultation' => function($q){
    //         $q->orderBy('consultations.created_at','desc');
    //     }])
    //     ->
    //     whereHas('consultations')
    //     ->
    //     withCount(['consultations as unread' => function ($query) use ($currentUserId) {
    //         $query->where('user_id', $currentUserId)
    //               ->where('type', 'answer')
    //               ->whereNull('read_at');
    //     }])
    //     // ->orderBy('created_at', 'desc')
    //     ->get();
    //     return $unreadCountPerDoctor;



    //     $query =  Consultation::query();
    //     $doctors =  $query
    //         // ->filt($request->all())
    //         ->with('doctor')
    //         // ->with(['doctor' => function ($q,$d) {
    //         //     $q->with(['consultaions' => function ($qq)use ($d) {
    //         //         $qq->selectRaw('count(consultations.read_at) as total_msg');
    //         //     }]);
    //         // }])
    //         // ->selectRaw('count(consultations.read_at) as total_msg')
    //         ->where('user_id', Auth::guard('sanctum')->id())

    //         ->latest()
    //         ->paginate();
    //     // return $doctors;
    //     $data = collect($doctors->all());
    //     $data = $data->groupBy(function ($item) {
    //         return $item->doctor_id;
    //     });
    //     $data  = $data->map(function ($a) {
    //         return $a->first();
    //     });
    //     // return $data;
    //     $dd = collect();
    //     foreach ($data as $key => $value) {
    //         $dd->push($value);
    //     }
    //     // return $dd;
    //     $data = collect($doctors);
    //     $data = $data->merge(['data' => $dd]);
    //     $data = $data->except('links');
    //     // return $data;

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'success',
    //         'consultations' => $data,
    //     ]);
    // }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsultationRequest $request)
    {

        // $path = Storage::disk('consultations')->put('images', $request->file('image'));
        $validateData = $request->validated();
        $validateData['user_id'] = Auth::guard('sanctum')->id();
        $path = $this->uploadImage($request);
        if ($path) {
            $validateData['image'] = $path;
        }
        $consultaions =  Consultation::create($validateData);
        $consultaions->load(['user', 'doctor']);
        if ($consultaions->type === 'answer') {
            $user =  $consultaions->user;
            $user->notify(new CreatedConsultationNotification($consultaions));
        } else {
            $doctor =  $consultaions->doctor;
            $doctor->notify(new CreatedConsultationNotification($consultaions));
        }
        return response()->json([
            'status' => 'success',
            'consultation' => $consultaions,
        ]);
    }

    protected function uploadImage(StoreConsultationRequest $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        return $file->store('images', "consultations");
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
