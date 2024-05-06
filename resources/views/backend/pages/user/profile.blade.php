@extends('backend.layout.template')

@section('page-title')
    <title>Admin Profile || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('frontend/fonts/icon.all.min.css') }}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .UpdateUser {
            display: block;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            object-fit: cover;
            margin: auto;
            margin-bottom: 30px;
            margin-top: 15px;
        }
    </style>
@endsection

@section('body-content')
    <div class="page-content"> 
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">
                {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}
            </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-12 d-flex">
                <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                    <h5 class="heading">Admin Profile</h5>
                    </div>

                    <div class="border p-3 radius-10">
                        <!-- Message -->
                        @include( 'backend.includes.message' )

                        <div class="container updateUser">
                            <div class="main-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center profile-image ">

                                                    @if( !is_null( Auth::user()->image ) )
                                                    <div class="profile-pic">
                                                        <a href="" class="addPopup" type="button" data-bs-toggle="modal" data-bs-target="#userId{{ Auth::user()->id }}"></a>
                                                        <img src="{{ asset('uploads/user/'.Auth::user()->image) }}" alt="" class="img-fluid">
                                                        {{-- remove image --}}
                                                        <form action="{{ route('profile-image-remove', Auth::user()->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="remove_image" value="1">
                                                            <button type="submit" class="btnProfileRemove">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                            
                                                     <!-- Modal -->
                                                     <div class="modal fade" id="userId{{ Auth::user()->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                   <i class="fa fa-window-close" aria-hidden="true"></i>
                                                                </button>
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                    Update Profile Picture
                                                                </h1>
                                                                </div>
                            
                                                                <div class="profile-pic">
                                                                    <img src="{{ asset('uploads/user/'.Auth::user()->image) }}" alt="" class="img-fluid" id="upImg">
                                                                    {{-- remove image --}}
                                                                    <form action="{{ route('profile-image-remove', Auth::user()->id) }}" method="POST" name="btnProfileRemove">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="remove_image" value="1">
                                                                        <button type="submit" id="btnProfileRemove">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                            
                                                                    {{-- upload image --}}
                                                                    <form action="{{ route('profile-image-update', Auth::user()->id) }}" method="POST" name="profileImageUpload" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input name="image" type="file" class="form-control profile-image-input image-upload" accept="">
                                                                        {{-- image/jpeg, image/jpg, image/png --}}
                                                                        <input type="submit" value="Upload Profile" name="btnAdd" class="btn btn-sm btn-solid">
                                                                    </form> 
                                                                    <button class="removeBtn">
                                                                       <span>&#10060;</span>
                                                                    </button>
                                                                </div>       
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="profile-pic">
                                                        <a href="" class="addPopup" type="button" data-bs-toggle="modal" data-bs-target="#userId{{ Auth::user()->id }}"></a>
                                                        <img src="{{ asset('backend/images/user.jpg') }}" alt="" class="img-fluid">
                                                        <button>
                                                            <i class="fas fa-camera text-light"></i>
                                                        </button>
                                                    </div>
                            
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="userId{{ Auth::user()->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                                                </button>
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                    Select Profile Picture
                                                                </h1>
                                                                </div>
                            
                                                                <div class="profile-pic">
                                                                    <img src="{{ asset('backend/images/user.jpg') }}" alt="" class="img-fluid" id="upImg">
                                                                    <button class="addBtn">
                                                                        <i class="fas fa-camera text-light"></i>
                                                                    </button>
                                                                    <button class="removeBtn">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                    <form action="{{ route('profile-image-update', Auth::user()->id) }}" method="POST" name="profileImageUpload" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input name="image" type="file" class="form-control profile-image-input image-upload">
                                                                        <input type="submit" value="Upload Profile" name="btnAdd" class="btn btn-sm btn-solid">
                                                                    </form>    
                                                                </div>           
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                    <div class="mt-3">
                                                        <h4>{{ $editData->name }}</h4>
                                                        <p class="text-secondary mb-1">
                                                            @if( !is_null( $editData->country_id ) )
                                                                Country: {{ $editData->country->name }}
                                                            @else
                                                                Role:
                                                                @if( $editData->role == 1 )
                                                                    Admin
                                                                @elseif( $editData->role == 2 )
                                                                    User 
                                                                @else
                                                                    Sub Admin
                                                                @endif
                                                            @endif
                                                        </p>
                                                        <p class="text-muted font-size-sm">
                                                            Join Date: {{ date('M-d-Y', strtotime($editData->created_at)) }}
                                                        </p>
                                                        <button class="btn btn-primary">Follow</button>
                                                        <button class="btn btn-outline-primary">Message</button>
                                                    </div>
                                                </div>
                                                
                                                <hr class="my-4">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">
                                                            <i class="fadeIn animated bx bx-user"></i>
                                                            Role: 
                                                        </h6>
                                                        <span class="text-secondary">
                                                            @if( Auth::user()->role == 1 )
                                                                Admin
                                                            @elseif( Auth::user()->role == 3 )
                                                                Sub Admin
                                                            @endif
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="{{ route('userInfo', Auth::user()->id) }}" method="post">
                                                    @csrf
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Full Name *</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <input type="text" class="form-control" name="name" value="{{ $editData->name }}">
                                                            @error('name')
                                                                <div class="text-danger"> {{ $message }} </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Email *</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <input type="text" class="form-control" name="email" value="{{ $editData->email }}">
                                                            @error('email')
                                                                <div class="text-danger"> {{ $message }} </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Phone</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <input type="text" class="form-control" name="phone" value="{{ $editData->phone }}">
                                                            @error('phone')
                                                                <div class="text-danger"> {{ $message }} </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Address Line 1</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <input type="text" class="form-control" name="address_line_1" value="{{ Auth::user()->address_line1 }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Address Line 2</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <input type="text" class="form-control" name="address_line_2" value="{{ Auth::user()->address_line2 }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Country</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <select class="country" name="country_id" id="country">
                                                                <option value="">Select your country name</option>
                                                                @foreach ( App\Models\Country::where('status', 1)->get() as $countries)
                                                                    <option value="{{ $countries->id }}" @if( $countries->id == Auth::user()->country_id ) selected @endif >{{ $countries->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">City / State</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <select class="state" name="state_id" id="state" disabled>
                                                                <option value="">Select your state name</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">District</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <select class="district" name="district_id" id="district" disabled>
                                                                <option value="">Select your district name</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Zip_code</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            <input type="text" name="zip_code" class="form-control" value="@if(!is_null($editData->zipCode)) {{$editData->zipCode}} @endif">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            
                                                        </div>
                                                        <div class="col-sm-9 text-secondary change-profile">
                                                            <input type="submit" name="submit" value="save changes">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="d-flex align-items-center mb-3">
                                                            Change Password
                                                        </h5>
                                                        <form action="{{ route('password.update') }}" method="POST" name="passwordForm">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label for="update_password_current_password">Current Password *</label>
                                                                    <input type="password" class="form-control" id="update_password_current_password" name="current_password" placeholder="******">
                                                                    <span class="text-danger"></span>
                                                                    @error('current_password')
                                                                        <span class="text-danger"> {{ $message }} </span>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-12 mb-3">
                                                                    <label for="update_password_password">New Password *</label>
                                                                    <input type="password" class="form-control" id="update_password_password" name="password" placeholder="******">
                                                                    
                                                                    @error('password')
                                                                        <span class="text-danger"> {{ $message }} </span>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-md-12 mb-3">
                                                                    <label for="update_password_password_confirmation">
                                                                        Confirm Password *
                                                                    </label>
                                                                    <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" placeholder="******">
                                                                    @error('password_confirmation')
                                                                        <span class="text-danger"> {{ $message }} </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <input type="submit" name="submit" value="Change Password" style="margin-top: 0">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
                </div>
            </div>
        </div>
    </div>        
@endsection

@section('page-script')
    {!! Toastr::message() !!}

    {{-- user image --}}
    @if( !is_null( Auth::user()->image) )
        <script>
            const img              = document.getElementById('upImg');
            const input            = document.querySelector(".image-upload");
            const btnRemove        = document.querySelector('.removeBtn');
            const btnClose         = document.querySelector('.btn-close');
            const form             = document.forms['profileImageUpload'];
            const btnProfileRemove = document.getElementById('btnProfileRemove');

            input.addEventListener("change", () => {
                img.src = URL.createObjectURL(input.files[0]);
                btnRemove.style.display = "block";
                btnRemove.innerHTML = `<span>&#10060;</span>`;
                btnRemove.style.zIndex = "5";

                if( img.src !== "{{ asset('uploads/user/'.Auth::user()->image) }}" ){
                    btnProfileRemove.remove();
                }

                let btnProfileRemove2 = document.getElementById('btnProfileRemove2')
                if( btnProfileRemove2 ){
                    btnProfileRemove2.remove();
                }
                typeError();
            }); 

            function typeError(){
                let fileType = input.files[0].type;
                let validType = ['image/jpeg', 'image/jpg', 'image/png'];

                if( !validType.includes(fileType) ){
                    img.src = "{{ asset('uploads/user/'.Auth::user()->image) }}";
                    btnRemove.innerHTML = ' <i class="fas fa-camera text-light"></i>';
                    btnRemove.style.zIndex = "0";
                    toastr.error('Please Select a Valid Picture', '', {"positionClass": "toast-top-right", "closeButton": true});
                    form['btnAdd'].onclick = (e) => {
                        e.preventDefault();
                        toastr.error('Please Select a Valid Picture', '', {"positionClass": "toast-top-right", "closeButton": true});
                    }
                }else {
                    toastr.clear();
                    emptyFile();
                }
            }

            function emptyFile(){
                form['btnAdd'].onclick = (e) => {
                    if( input.value == '' ){
                        e.preventDefault();
                        toastr.warning('Select a New Profile Picture', '', {"positionClass": "toast-top-right", "closeButton": true});
                    }else {
                        toastr.clear();
                    }
                }
            }
            emptyFile();

            btnRemove.addEventListener('click', function(){
                img.src = "{{ asset('uploads/user/'.Auth::user()->image) }}";
                input.value = null; 
                this.style.display = "none";
                this.style.zIndex = "-1";
                toastr.clear();
            
                if(btnProfileRemove){
                    let addElement = document.createElement('button');
                    addElement.innerHTML = '<i class="fas fa-trash"></i>';
                    addElement.id  = "btnProfileRemove2";
                    addElement.setAttribute('type', 'submit');
                    let parent     = document.forms['btnProfileRemove']
                    parent.insertBefore(addElement, parent.lastElementChild)  
                }  
            }) 

            btnClose.addEventListener('click', function(){
                img.src = "{{ asset('uploads/user/'.Auth::user()->image) }}";
                input.value = null; 
                btnRemove.style.display = "none";
                btnRemove.style.zIndex = "-1";
                toastr.clear();

                if(btnProfileRemove){
                    let addElement = document.createElement('button');
                    addElement.innerHTML = '<i class="fas fa-trash"></i>';
                    addElement.id  = "btnProfileRemove2";
                    addElement.setAttribute('type', 'submit');
                    let parent     = document.forms['btnProfileRemove']
                    parent.insertBefore(addElement, parent.lastElementChild)  
                }  
            }) 
        </script>
    @else
        <script>
            const img       = document.getElementById('upImg');
            const input     = document.querySelector(".image-upload");
            const btnRemove = document.querySelector('.removeBtn');
            const btnClose  = document.querySelector('.btn-close');
            const form      = document.forms['profileImageUpload'];

            input.addEventListener("change", () => {
                img.src = URL.createObjectURL(input.files[0]);
                btnRemove.style.display = "block";
                btnRemove.style.zIndex = "5";
                typeError();
            }); 

            function typeError(){
                let fileType = input.files[0].type;
                let validType = ['image/jpeg', 'image/jpg', 'image/png'];

                if( !validType.includes(fileType) ){
                    img.src = "{{ asset('backend/images/user.jpg') }}";
                    btnRemove.style.display = "none";
                    btnRemove.style.zIndex = "-1";
                    toastr.error('Please Select a Valid Picture', '', {"positionClass": "toast-top-right", "closeButton": true});
                    form['btnAdd'].onclick = (e) => {
                        e.preventDefault();
                        toastr.error('Please Select a Valid Picture', '', {"positionClass": "toast-top-right", "closeButton": true});
                    }
                }else {
                    toastr.clear();
                    emptyFile();
                }
            }

            btnRemove.addEventListener('click', function(){
                img.src = "{{ asset('backend/images/user.jpg') }}";
                input.value = null; 
                this.style.display = "none";
                this.style.zIndex = "-1";
                toastr.clear();
            }) 

            function emptyFile(){
                form['btnAdd'].onclick = (e) => {
                    if( input.value == '' ){
                        e.preventDefault();
                        toastr.warning('Please Select a Picture', '', {"positionClass": "toast-top-right", "closeButton": true});
                    }else {
                        toastr.clear();
                    }
                }
            }
            emptyFile()

            btnClose.addEventListener('click', function(){
                img.src = "{{ asset('backend/images/user.jpg') }}";
                input.value = null; 
                btnRemove.style.display = "none";
                btnRemove.style.zIndex = "-1";
                toastr.clear();
            }) 
            
        </script>
    @endif

    {{-- validation --}}
    <script>
        let passwordForm = document.forms['passwordForm'];
        passwordForm['submit'].addEventListener('click', function(e){
            if( passwordForm['password'].value != passwordForm['password_confirmation'].value ){
                e.preventDefault();
                toastr.error('The password confirmation does not match. Try Again.', '', {"positionClass": "toast-top-right", "closeButton": true}); 
            }
        })
    </script>

    {{-- country state district --}}
    <script>
        let country     = document.getElementById('country');
        let state       = document.getElementById('state');
        let district    = document.getElementById('district');
        let allOptions  = '';
        let countryId   = country.value;
        let stateId     = state.value;

            let allStateOptions = '';
            let allDistrictOptions = '';

            if (countryId != 0 || countryId != '') {
                // Fetch states based on the selected country
                fetch('http://127.0.0.1:8000/get-state/' + countryId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length != 0) {
                            data.forEach(stateData => {
                                allStateOptions += `<option value="${stateData.id}">${stateData.name}</option>`;
                            });
                            state.innerHTML = allStateOptions;
                            state.removeAttribute('disabled');
                            // selected opiton
                            if ('{{ Auth::user()->division_id }}' !== "") {
                                state.value = '{{ Auth::user()->division_id }}';
                            }
                            let stateId = state.value;

                            // Fetch districts based on the selected state
                            fetch('http://127.0.0.1:8000/get-district/' + stateId)
                                .then(response => response.json())
                                .then(districtData => {
                                    if (districtData.length != 0) {
                                        districtData.forEach(district => {
                                            allDistrictOptions += `<option value="${district.id}">${district.name}</option>`;
                                        });
                                        district.innerHTML = allDistrictOptions;
                                        district.removeAttribute('disabled');
                                        // selected opiton
                                        if ('{{ Auth::user()->district_id }}' !== "") {
                                            district.value = '{{ Auth::user()->district_id }}';
                                        }
                                    } else {
                                        district.innerHTML = '<option value="">No district available in this state/division</option>';
                                        district.removeAttribute('disabled');
                                    }
                                })
                                .catch(err => {
                                    console.log(err.message);
                                });
                        } else {
                            state.innerHTML = '<option value="">No state available in this country</option>';
                            state.removeAttribute('disabled');
                        }
                    })
                    .catch(err => {
                        console.log(err.message);
                    });
            } else {
                state.innerHTML = '<option value="">Select your state name</option>';
                state.setAttribute('disabled', 'disabled');
                district.innerHTML ='<option value="">Select your district name</option>';
                district.setAttribute('disabled', 'disabled');
            }

        country.addEventListener('change', function(){
            countryId = this.value;
            let allStateOptions = '';
            let allDistrictOptions = '';

            if (countryId != 0 || countryId != '') {
                // Fetch states based on the selected country
                fetch('http://127.0.0.1:8000/get-state/' + countryId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length != 0) {
                            data.forEach(stateData => {
                                allStateOptions += `<option value="${stateData.id}">${stateData.name}</option>`;
                            });
                            state.innerHTML = allStateOptions;
                            state.removeAttribute('disabled');
                            let stateId = state.value;

                            // Fetch districts based on the selected state
                            fetch('http://127.0.0.1:8000/get-district/' + stateId)
                                .then(response => response.json())
                                .then(districtData => {
                                    if (districtData.length != 0) {
                                        districtData.forEach(district => {
                                            allDistrictOptions += `<option value="${district.id}">${district.name}</option>`;
                                        });
                                        district.innerHTML = allDistrictOptions;
                                        district.removeAttribute('disabled');
                                    } else {
                                        district.innerHTML = '<option value="">No district available in this state/division</option>';
                                        district.removeAttribute('disabled');
                                    }
                                })
                                .catch(err => {
                                    console.log(err.message);
                                });
                        } else {
                            state.innerHTML = '<option value="">No state available in this country</option>';
                            state.removeAttribute('disabled');
                        }
                    })
                    .catch(err => {
                        console.log(err.message);
                    });
            } else {
                state.innerHTML = '<option value="">Select your state name</option>';
                state.setAttribute('disabled', 'disabled');
                district.innerHTML ='<option value="">Select your district name</option>';
                district.setAttribute('disabled', 'disabled');
            }
        });

        state.addEventListener('change', function(){
            stateId = this.value;
            let allDistrict = '';

            if( stateId != 0 || stateId != '' ){
                fetch('http://127.0.0.1:8000/get-district/' + stateId)
                    .then(response => response.json())
                    .then(data => {
                        if( data.length != 0 ){
                                data.map(allData => {
                                allDistrict += `<option value="${allData.id}">${allData.name}</option>`;
                            });
                                district.innerHTML = allDistrict;
                                district.removeAttribute('disabled')
                            }else {
                                district.innerHTML ='<option value="">No district available in this state/division</option>';
                                district.removeAttribute('disabled')
                            }
                        })
                        .catch(err => {
                            console.log(err.message);
                        });
            }else {
                district.innerHTML ='<option value="">Select your district name</option>';
                district.setAttribute('disabled', 'disabled');
            }
        })

    </script>
@endsection
