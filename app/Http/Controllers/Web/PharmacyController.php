<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PharmacyRequest;
use App\Models\Pharmacy;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacies = Pharmacy::all();
        // dd($pharmacies);
        return view('web.pharmacy.pharmacies', compact('pharmacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pharmacy = new Pharmacy();
        return view('web.pharmacy.create-pharmacy',compact('pharmacy'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PharmacyRequest $request)
    {
        // 'password' => Hash::make($request->password)
        // dd($request->all());
        $data = $request->except(['logo_image','password']);
        // dd($data);
        
        $data['logo_image'] = $this->uploadImage($request);
        // dd($data);
        $data['password'] = \Hash::make($request->password);
        Pharmacy::create($data);
        
        return redirect()->back()->with([
            'message' => "created success new pharmacy {$data['name']} "
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        // dd($pharmacy);
        return view('web.pharmacy.edit-pharmacy', compact('pharmacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        // dd($pharmacy);
        return view('web.pharmacy.edit-pharmacy', compact('pharmacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pharmacy = Pharmacy::findOrFail($id);
        $old_image = $pharmacy->logo_image;
        $data = $request->except('logo_image');
        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['logo_image'] = $new_image;
        }
        $pharmacy->update($data);

        if ($old_image && $new_image) {
            Storage::disk('uploads')->delete($old_image);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'updated success');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id  )
    {
        $pharmacy =    Pharmacy::find($id);


        $old_image = $pharmacy->logo_image;
        $pharmacy->delete();

        if (isset($old_image)) {
            Storage::disk('uploads')->delete($old_image);
        }
        return [
            'message'=> 'item delete success'
        ];
    }
    protected function uploadImage(Request $request)
    {
            if (!$request->hasFile('logo_image')) {
                return;
            }
            $file = $request->file('logo_image');
            return $file->store('pharmacy', "uploads");
    }
}
