<!-- resources/views/patients/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Patient Details</h1>

        <div class="col-sm-12 col-mg-6 col-lg-4 mb-4">
    <div class="card">
        <div class="card-header h3">Patient Details</div>
        <div class="card-body">
            <p><strong>Name:</strong>{{$patient->name}}</p>
            <p><strong>Date of Birth:</strong>{{$patient->dob}}</p>
            <p><strong>Gender:</strong>{{$patient->gender}}</p>
            <p><strong>Contact:</strong>{{$patient->phone_number}}</p>
        </div>
        <div class="card-footer p-0 mx-0" style="display: inline;">
        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary col-12">Edit Details</a>  
        </div>
    </div>
</div>

<div class="col-sm-12 col-mg-6 col-lg-4 mb-4">
    <div class="card">
        <div class="card-header h3">Patient Qr-code</div>
        <div class="card-body text-center">
            <img src="{{ asset('storage/' . $patient->qr_code) }}" alt="{{$patient->qr_code}}" title="{{$patient->qr_code}}">
        </div>
        <a href="{{ asset('storage/' . $patient->qr_code) }}" download class="text-decoration-none">
            <div class="card-footer text-center text-light bg-primary">Download</div>
        </a>
    </div>
</div>
        
    </div>
@endsection
