<!-- resources/views/patients/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Patient Details</h1>
        
        <form method="POST" action="{{ route('patients.update', $patient->id) }}">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" value="{{ old('name', $patient->name) }}" required>
            </div>

            <div>
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" value="{{ old('dob', $patient->dob) }}" required>
            </div>

            <div>
                <label for="address">Address:</label>
                <input type="text" name="address" value="{{ old('address', $patient->address) }}" required>
            </div>

            <div>
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $patient->phone_number) }}" required>
            </div>

            <div>
                <label for="gender">Gender:</label>
                <input type="text" name="gender" value="{{ old('gender', $patient->gender) }}" required>
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
@endsection
