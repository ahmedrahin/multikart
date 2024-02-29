@extends('frontend.layout.template')

@section('page-title')
    <title>Profile Verification || Multikart</title>
@endsection

@section('page-css')
    
@endsection

@section('body-content')
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>Profile Verification</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">login</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container login-page">
        <div class="row">

            <div class="col-lg-6 col-md-6 offset-lg-3 offset-md-3">
                <div class="theme-card authentication-right email-verify">
                    <h6 class="title-font">Verify Your Email</h6>
                    <p>
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </p>
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-solid">Resend Verification Email</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-script')

@endsection
