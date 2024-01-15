<!-- resources/views/hospital/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hospital List</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hospitals as $hospital)
                <tr>
                    <td>{{ $hospital->id }}</td>
                    <td>{{ $hospital->name }}</td>
                    <td>{{ $hospital->location }}</td>
                    <td>{{ $hospital->contact }}</td>
                    <td>{{ $hospital->email }}</td>
                    <td>
                        <a href="{{ route('hospital.show', $hospital->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('hospital.edit', $hospital->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('hospital.destroy', $hospital->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hospitals found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('hospital.register') }}" class="btn btn-success">Add Hospital</a>
</div>
@endsection
