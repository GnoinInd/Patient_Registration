<?php
namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::all();
        return view('hospital.index', compact('hospitals'));
    }

    public function register()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'contact' => 'required',
            'email' => 'required|email|unique:hospitals',
        ]);
    
        // Get the authenticated user's ID
        
        $user_id = Auth::id();
        $hospital = Hospital::create([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'user_id' => $user_id, // Associate the hospital with the authenticated user
        ]);
    
        $qrCode = QrCode::Generate(route('patients.register',$hospital->id));
        $qrCodePath = 'hospital-qrcode' . $hospital->id . '.svg';
        Storage::disk('public')->put($qrCodePath, $qrCode);
        $hospital->update(['qrcode' => $qrCodePath]);


        return redirect()->route('dashboard')->with('success', 'Hospital registered successfully.');
    }
    

    public function show(Hospital $hospital)
    {
        return view('hospital.show', compact('hospital'));
    }

    public function edit(Hospital $hospital)
    {
        //decrypt hashed id
        
        return view('hospital.edit', compact('hospital'));
    }

    public function update(Request $request, Hospital $hospital)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'contact' => 'required',
            'email' => 'required|email|unique:hospitals,email,' . $hospital->id,
        ]);

        $hospital->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Hospital updated successfully.');
    }

    public function destroy(Hospital $hospital)
    {
        $hospital->delete();

        return redirect()->route('hospital.register')->with('success', 'Hospital deleted successfully.');
    }

}
