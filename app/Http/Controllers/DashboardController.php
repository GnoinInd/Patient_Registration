<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $hospitals = Hospital::where('user_id', $user_id)->get();
        return view('dashboard.index', compact('hospitals'));
    }

    public function patientsIndex()
    {

        $patients = Patient::join('hospitals', 'patients.user_id', '=', 'hospitals.user_id')
        ->where('hospitals.user_id', Auth::id())
        ->select('patients.*')
        ->get();
    
        return view('dashboard.patients',compact('patients'));
    }

    public function getPatients(Request $request)
    {
        if ($request->ajax()) {
            $patients = Patient::latest()->get();

            return DataTables::of($patients)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct" id="createNewProduct">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.patients',compact('request'));
    }

    public function storePatient(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'dob' => 'required|date',
            'address' => 'required',
            'phone_number' => 'required|max:10',
            'gender' => 'required',
        ]);

        $user_id = Auth::id();

        $patient = Patient::updateOrCreate([
            'name' => $request->input('name'),
            'dob' => $request->input('dob'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'gender' => $request->input('gender'),
            'user_id' => $user_id,
        ]);

        $qrCode = QrCode::generate(route('patients.register', $patient->id));
        $qrCodePath = 'patient-qrcode' . $patient->id . '.svg';
        Storage::disk('public')->put($qrCodePath, $qrCode);

        $patient->update(['qr_code' => $qrCodePath]);

        return response()->json(['success' => 'Patient saved successfully.']);
    }

    public function updatePatient(Request $request, $id)
    {
        // Your update patient logic here
    }

    public function deletePatient($id)
    {
        $patient = Patient::find($id);
        if ($patient) {
            $patient->delete();
            return response()->json(['success' => 'Record Deleted successfully']);
        }

        return response()->json(['error' => 'Patient not found']);
    }
}
