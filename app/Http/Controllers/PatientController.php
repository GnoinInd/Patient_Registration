<?php

// app/Http/Controllers/PatientController.php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{

    public function register()
    {
        $hospitals = Hospital::where('user_id', Auth::id())->get();
        return view('patients.register',compact('hospitals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'dob' => 'required|date',
            'address' => 'required',
            'phone_number' => 'required|max:10',
            'gender' => 'required',
        ]);
    
        // Get the authenticated user's ID
        $user_id = Auth::id();
    
        $patient = Patient::create([
            'name' => $request->input('name'),
            'dob' => $request->input('dob'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'gender' => $request->input('gender'),
            'user_id' => $user_id, // Associate the hospital with the authenticated user
        ]);
    
        $qrCode = QrCode::generate(route('patients.show', $patient->id));
        $qrCodePath = 'patient-qrcode' . $patient->id . '.svg';
        Storage::disk('public')->put($qrCodePath, $qrCode);
    
        $patient->update(['qr_code' => $qrCodePath]);
    
        return redirect()->route('patients.show',$patient)->with('success', 'Hospital registered successfully.');
    }
    

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required',
            'dob' => 'required|date',
            'address' => 'required',
            'phone_number' => 'required|max:10',
            'gender' => 'required',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.show')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.show')->with('success', 'Patient deleted successfully.');
    }
}
