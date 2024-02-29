@extends('frontend.layout.template')

@section('page-title')
    <title>Register || Multikart</title>
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
                        <h2>create account</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">create account</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <!--section start-->
    <section class="register-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>create account</h3>
                    <div class="theme-card">
                        <form class="theme-form" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-row row mb-3">
                                <div class="col-md-6">
                                    <label for="name">Your Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Your Name"
                                    name="name" value="{{ old('name') }}" autofocus autocomplete="name">
                                    @error('name')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Your Email</label>
                                    <input type="text" id="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="username">
                                    @error('email')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <label for="password">Password</label>
                                    <div class="password">
                                        <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" autocomplete="new-password">
                                        <span><i class="fa fa-eye-slash showIcone" aria-hidden="true" id="togglePassword" aria-hidden="true"></i></span>
                                    </div>
                                    @error('password')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="review">Confirm Password</label>
                                    <input type="password" class="form-control" id="review"  placeholder="Confirm Password" name="password_confirmation" autocomplete="new-password">
                                    @error('password_confirmation')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-solid w-auto btn-login">create Account</button>
                                </div>
                                <div class="col-md-6">
                                    <p class="forgotPass">
                                        <a href="{{ route('login') }}">
                                             <label>Already have an account?</label>
                                         </a>
                                     </p>
                                </div>
                                
                            </div>
                        </form>
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


   


  