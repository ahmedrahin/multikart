@extends('frontend.layout.template')

@section('page-title')
    <title>Forget Password || Multikart</title>
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
                        <h2>forget password</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('login') }}">login</a></li>
                            <li class="breadcrumb-item active" aria-current="page">forget password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="pwd-page section-b-space login-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto theme-card">
                    <h2>Forget Your Password</h2>
                    <p class="mb-5">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                    <x-auth-session-status class="mb-4 text-green-600" :status="session('status')" />
                    <form class="theme-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-row row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="email" placeholder="Enter Your Email" value={{ old('email') }} >
                                @error('email')
                                    <span class="text-danger mb-4"> {{ $message }} </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-solid w-auto">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection

@section('page-script')
    
@endsection