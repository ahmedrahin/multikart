@extends('frontend.layout.template')

@section('page-title')
    <title>My Profile || Multikart</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('frontend/fonts/icon.all.min.css') }}">
@endsection

@section('body-content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>profile</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    {{-- profile picture --}}
    <section class="profile-image">
        <div class="container">
            <div class="row">
                <div class="col-12">

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
                                        <i class="fas fa-window-close"></i>
                                    </button>
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        Select Profile Picture
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
                                        <i class="fas fa-window-close"></i>
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
                    
                </div>
            </div>
        </div>
    </section>

    <!-- personal deatail section start -->
    <section class="contact-page register-page user-profile">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>PERSONAL DETAILS</h3>
                    <form class="theme-form" action="{{ route('personal-details-update', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="col-md-4 mb-4">
                                <label for="name">Full Name *</label>
                                <input type="text" value="{{ Auth::user()->name }}" class="form-control" id="name" name="name" placeholder="Enter Your name">
                                @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="email">Email *</label>
                                <input type="text" value="{{ Auth::user()->email }}" class="form-control" id="email" name="email" placeholder="Email">
                                @error('email')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="phone">Phone number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}" placeholder="Enter your number">
                                @error('phone')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-solid" type="submit">SAVE CHANGES</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

    <!-- address section start -->
    <section class="contact-page register-page section-b-space user-profile">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>SHIPPING ADDRESS</h3>
                    <form class="theme-form" action="{{ route('shipping-details-update', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="col-md-6 mb-4">
                                <label for="address-line-1">Address Line 1</label>
                                <input type="text" class="form-control" name="address_line_1" value="{{ Auth::user()->address_line1 }}" id="address-line-1" placeholder="Street Address">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="address-line-2">Address Line 2</label>
                                <input type="text" class="form-control" id="address_line_2" name="address_line_2" value="{{ Auth::user()->address_line2 }}" placeholder="Street Address">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="zip-code">Zip Code</label>
                                <input type="text" class="form-control" id="zip-code" name="zip_code" value="{{ Auth::user()->zipCode }}" placeholder="zip-code">
                            </div>

                            <div class="col-md-6 mb-4 select_input">
                                <label for="country">Country</label>
                                <select class="form-control" id="country" name="country_id">
                                    <option value="">Select your country name</option>
                                    @foreach ($country as $countries)
                                        <option value="{{ $countries->id }}" @if( $countries->id == Auth::user()->country_id ) selected @endif >{{ $countries->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4 select_input">
                                <label for="state">City / State</label>
                                <select class="form-control" id="state" name="division_id" disabled>
                                    <option value="">Select your state name</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4 select_input">
                                <label for="district">District</label>
                                <select class="form-control" id="district" name="district_id" disabled>
                                    <option value="">Select your district name</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-solid" type="submit">SAVE CHANGES</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->

    {{-- password section start --}}
    <section class="contact-page register-page user-profile" style="padding-top: 0; padding-bottom: 70px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Update Password</h3>
                    <form class="theme-form" action="{{ route('password.update') }}" method="POST" name="passwordForm">
                        @csrf
                        @method('PUT')
                        <div class="form-row row">

                            <div class="col-md-4 mb-4">
                                <label for="update_password_current_password">Current Password *</label>
                                <input type="password" class="form-control" id="update_password_current_password" name="current_password" placeholder="******">
                                @error('current_password')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="update_password_password">New Password *</label>
                                <input type="password" class="form-control" id="update_password_password" name="password" placeholder="******">
                                @error('password')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <label for="update_password_password_confirmation">Confirm Password *</label>
                                <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" placeholder="******">
                                @error('password_confirmation')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-solid" name="submit">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    {{-- password section end --}}

@endsection

@section('page-script')
    {!! Toastr::message() !!}
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

    {{-- password validation --}}
    <script>
        let passwordForm = document.forms['passwordForm'];
        passwordForm['submit'].addEventListener('click', function(e){
            if( passwordForm['current_password'].value == '' ){
                e.preventDefault();
                toastr.error('Current Password field is required', '', {"positionClass": "toast-top-right", "closeButton": true}); 
            }else if( passwordForm['password'].value != passwordForm['password_confirmation'].value ){
                e.preventDefault();
                toastr.error('The password confirmation does not match. Try Again.', '', {"positionClass": "toast-top-right", "closeButton": true}); 
                passwordForm.reset();
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
                fetch('/get-state/' + countryId)
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
                            fetch('/get-district/' + stateId)
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
           

  