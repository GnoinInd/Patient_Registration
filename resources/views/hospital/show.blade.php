<!-- resources/views/hospital/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hospital Details</h1>

    <div class="mb-3">
        <strong>Name:</strong> {{ $hospital->name }}
    </div>

    <div class="mb-3">
        <strong>Location:</strong> {{ $hospital->location }}
    </div>

    <div class="mb-3">
        <strong>Contact:</strong> {{ $hospital->contact }}
    </div>

    <div class="mb-3">
        <strong>Email:</strong> {{ $hospital->email }}
    </div>

    <div class="mb-3">
        <strong>QR Code:</strong>
        @if ($hospital->qrcode)
            <img src="{{ asset('storage/' . $hospital->qrcode) }}" alt="QR Code" class="img-fluid">
        @else
            <p>No QR Code available</p>
        @endif
    </div>

    <a href="{{ route('hospital.edit', $hospital->id) }}" class="btn btn-primary">Edit Hospital</a>
</div>
@endsection
