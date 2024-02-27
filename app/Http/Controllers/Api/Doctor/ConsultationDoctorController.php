<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consultation\StoreConsultationDoctorRequest;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\User;
use App\Notifications\CreatedConsultationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultationDoctorController extends Controller
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
    public function users()
    {
        $currentDoctorId =  Auth::guard('sanctum')->id();
        $query =  Consultation::query();
        $doctors =  $query->join('users', 'consultations.user_id', 'users.id')
            ->with(['user' => function ($q) use ($currentDoctorId) {
                // $q->join('consultations', 'consultations.doctor_id', 'doctors.id');//->latest('consultations.created_at');
                $q->withCount(['consultations as unread_count' => function ($qq) use ($currentDoctorId) {
                    $qq->where('doctor_id', $currentDoctorId)->whereNull('read_at')->where('type', 'question');
                }]);
                $q->with(['consultation' => function ($qq) use ($currentDoctorId) {
                    $qq->where('doctor_id', $currentDoctorId);
                }]);
            }])
            ->select("user_id", DB::raw(' count(*) as total'))
            ->where('doctor_id', $currentDoctorId)
            ->groupBy('consultations.user_id')
            ->latest('consultations.created_at')
            ->paginate();
        // return $doctors->all();
        $data = collect($doctors->all());
        $dd = collect();
        foreach ($data as   $value) {
            $dd->push($value['user']);
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
    public function marksRead(Request $request)
    {
        $currentDoctorId =  Auth::guard('sanctum')->id();
        $userId =  $request->input('user_id');

        $consultations =  Consultation::where('doctor_id', $currentDoctorId)
            ->where('user_id', $userId)
            ->where('type', 'question')
            ->get();
        foreach ($consultations as   $consultation) {
            $consultation->update(['read_at' => now()]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'marks read were success',
        ]);
    }

    // public function users(Request $request)
    // {
    //     $query =  Consultation::query();
    //     $users =  $query
    //         // ->filt($request->all())
    //         ->with('user')
    //         ->where('doctor_id', Auth::id())
    //         ->latest()
    //         ->paginate();
    //     // return $users;
    //     $data = collect($users->all());
    //     $data = $data->groupBy(function ($item) {
    //         return $item->user_id;
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
    //     $data = collect($users);
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
    public function store(StoreConsultationDoctorRequest $request)
    {

        // $path = Storage::disk('consultations')->put('images', $request->file('image'));
        $validateData = $request->validated();
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

    protected function uploadImage(StoreConsultationDoctorRequest $request)
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
