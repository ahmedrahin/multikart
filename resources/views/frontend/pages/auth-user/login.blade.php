@extends('frontend.layout.template')

@section('page-title')
    <title>Log In || Multikart</title>
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
                        <h2>customer's login</h2>
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
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Login</h3>
                    <div class="theme-card">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <form class="theme-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control" id="email" placeholder="Email Address" autofocus autocomplete="username">
                                @error('email')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="password">
                                    <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" autocomplete="new-password">
                                    <span><i class="fa fa-eye-slash showIcone" aria-hidden="true" id="togglePassword" aria-hidden="true"></i></span>
                                </div>
                                @error('password')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6">
                                    <button type="submit" class="btn btn-solid btn-login">Login</button>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    @if (Route::has('password.request'))
                                        <p class="forgotPass">
                                           <a href="{{ route('forget-password') }}">
                                                <label>Forgot your password?</label>
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-6 right-login">
                    <h3>New Customer</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">Create A Account</h6>
                        <p>Sign up for a free account at our store. Registration is quick and easy. It allows you to be
                            able to order from our shop. To start shopping click register.</p><a href="{{ route('register') }}"
                            class="btn btn-solid">Create an Account</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section ends-->
@endsection

@section('page-script')
    <script>
        //password show & hidden button
        let passwordInput = document.getElementById('password');
        let togglePassword = document.getElementById('togglePassword');
        
        passwordInput.addEventListener('input', () => {
            togglePassword.style.display = ( passwordInput.value.length > 0 ) ? "block" : "none";
        })

        togglePassword.onclick = function(){
            if( passwordInput.type == "password" ){
                passwordInput.type = "text";
                togglePassword.className = "fa fa-eye";
            }else {
                passwordInput.type = "password";
                togglePassword.className = "fa fa-eye-slash";
            }
        }        
    </script>
@endsection