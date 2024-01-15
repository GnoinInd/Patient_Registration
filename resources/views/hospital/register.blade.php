<!-- resources/views/hospital/create.blade.php -->



@section('content')
<div class="wrapper">
    <h1 class="mt-5">Register Hospital</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
        </div>
    @endif

    <form action="{{ route('hospital.store') }}" class="p-3 mt-3" method="POST">
        @csrf
        @method('POST')
@if (Auth::user())
    

        <div class="form-field d-flex align-items-center">
            <span class="fa fa-user"></span>
            <input type="text" class="" id="name" name="name" value="{{ Auth::user()->name }}" required readonly>
        </div>@endif

        <div class="form-field d-flex align-items-center">
            <span class="fa fa-map"></span>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
        </div>

        <div class="form-field d-flex align-items-center">
            <span class="fa fa-phone"></span>
            <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact') }}" required>
        </div>

        @if (Auth::user())
        <div class="form-field d-flex align-items-center">
            <span class="fa fa-envelope"></span>
            <input type="email" class="form-control" id="email" name="email" value="{{Auth::user()->email}}" required readonly>
        </div>@endif


        <button type="submit" class="btn btn-primary">Create Hospital</button>
    </form>
</div>
@endsection
