@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-success alert-dismissible">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

  @foreach ($errors->all() as $error)
                <strong>{{ $error }}</strong>
            @endforeach
</div>
@endif

<div class="wrapper">

        <form class="p-3 mt-3" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="logo" onclick="openFileInput()">
  <div class="profile-pic">
    <img alt="User Pic" src="https://d30y9cdsu7xlg0.cloudfront.net/png/138926-200.png" id="profile-image1" height="200">
    <input id="profile-image-upload" class="hidden" name="profile_image" type="file" onchange="previewFile()">
  </div>
</div>

            <div class="form-field d-flex align-items-center">
                <i class="fa fa-user"></i>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror shadow-none" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Hospital name">
            
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fa fa-envelope "></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror shadow-none" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Mail">
               
            </div>

            <div class="form-field d-flex align-items-center">
                <span class="fa fa-key"></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror shadow-none" name="password" required autocomplete="new-password" placeholder="password">
            </div>


            <div class="form-field d-flex align-items-center">
                <span class="fa fa-key"></span>
                <input id="password-confirm" type="password" class="form-control shadow-none" name="password_confirmation" required autocomplete="new-password" placeholder="confirm password">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
            </div>
        </form>


@endsection

