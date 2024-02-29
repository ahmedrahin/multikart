@extends('frontend.layout.template')

@section('page-title')
    <title>Reset Password || Multikart</title>
@endsection

@section('page-css')
    
@endsection

@section('body-content')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>reset password</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('login') }}">login</a></li>
                            <li class="breadcrumb-item active" aria-current="page">reset password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <section class="pwd-page section-b-space login-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto theme-card">
                    <h2>Reset Your Password</h2>
                    <form class="theme-form reset-pass" method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div>
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ old('email', $request->email) }}" class="form-control" id="email" placeholder="Email Address">
                            @error('email')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="*****">
                            @error('password')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="*****">
                            @error('password_confirmation')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="btn btn-solid btn-login">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-script')
    
@endsection
