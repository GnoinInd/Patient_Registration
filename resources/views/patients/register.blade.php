<!-- resources/views/patients/register.blade.php -->

@extends('layouts.app')
@section('content')
<div class="wrapper">
        <h1 class="mt-5 fs-3">Patient Registration @foreach ($hospitals as $hospital)
        ({{$hospital->name}})
        @endforeach</h1>

@if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
    </div>
@endif
        <div class="row">
        <form action="{{ route('patients.store') }}" class="p-3 mt-3" method="POST">
            @csrf
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" required class="form-control">
            <br>

            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" name="dob" required class="form-control">
            <br>

            <label for="address" class="form-label">Address:</label>
            <input type="text" name="address" required class="form-control">
            <br>

            <label for="phone_number" class="form-label">Phone Number:</label>
            <input type="text" name="phone_number" required class="form-control">
            <br>

            <label for="gender" class="form-label">Gender:</label>
            <input type="text" name="gender" required class="form-control">
            <br>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        </div>
    </div>
@endsection
