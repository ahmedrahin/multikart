@extends('frontend.layout.template')

@section('page-title')
    <title>My Profile || Multikart</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    {{-- custom --}}
    <style>
        .is-invalid{
            border: 1px solid #dc3545 !important;
        }
        .form-control.is-invalid:focus {
            box-shadow: none !important;
        }
    </style>
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
        @include('frontend.includes.profile-img')
    </section>

    <!-- personal deatail section start -->
    <section class="contact-page register-page user-profile">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>PERSONAL DETAILS</h3>
                    <form class="theme-form" action="{{ route('personal-details-update', Auth::user()->id) }}" method="POST" id="personal-details-form">
                        @csrf
                        @method('PUT')
                        <div class="form-row row">
                            <div class="col-md-4 mb-3">
                                <label for="name">Full Name *</label>
                                <input type="text" value="{{ Auth::user()->name }}" class="form-control" id="name" name="name" placeholder="Enter Your name">
                                <span class="text-danger"> </span>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="email">Email *</label>
                                <input type="text" value="{{ Auth::user()->email }}" class="form-control" id="email" name="email" placeholder="Email">
                                <span class="text-danger"> </span>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="phone">Phone number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}" placeholder="Enter your number">
                                <span class="text-danger">  </span>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-solid" id="btnperDel">SAVE CHANGES</button>
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
                    <form class="theme-form" action="{{ route('shipping-details-update', Auth::user()->id) }}" method="POST" id="shipping-form">
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
                                <button type="submit" class="btn btn-sm btn-solid" id="btnShippInfo">SAVE CHANGES</button>
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
                    <form class="theme-form" action="{{ route('password.update') }}" method="POST" name="passwordForm" id="passwordForm">
                        @csrf
                        @method('PUT')
                        <div class="form-row row">

                            <div class="col-md-4 mb-3">
                                <label for="update_password_current_password">Current Password *</label>
                                <input type="password" class="form-control" id="update_password_current_password" name="current_password" placeholder="******">
                                <span class="text-danger"></span>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="update_password_password">New Password *</label>
                                <input type="password" class="form-control" id="update_password_password" name="password" placeholder="******">
                                <span class="text-danger"></span>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="update_password_password_confirmation">Confirm Password *</label>
                                <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" placeholder="******">
                                <span class="text-danger"></span>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-solid" id="changePass">Update Password</button>
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
   
    {{-- password validation --}}
    {{-- <script>
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
    </script> --}}

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
                fetch('/get-state/' + countryId)
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
                            fetch('/get-district/' + stateId)
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
                fetch('/get-district/' + stateId)
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
    
    {{-- ajax send --}}
    <script>
        $(document).ready(function() {
            // send personal details
            $('#btnperDel').prop('disabled', true);

            // Enable the submit button when any input field changes
            $('#personal-details-form input').on('input', function() {
                $('#btnperDel').prop('disabled', false);
            });

            $('#personal-details-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                // Send Ajax request
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'PUT',
                    data: formData,
                    beforeSend: function(){
                        $("#btnperDel").prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        `);
                        $('#btnperDel').css('width', '154px');
                        $('#btnperDel').css('height', '41px');
                    },
                    success: function(response) {
                        $("#btnperDel").prop('disabled', false).html('SAVE CHANGES');
                        toastr.success('Your Information is Updated', '', {"positionClass": "toast-top-right", "closeButton": true});
                        $('#personal-details-form').find('.text-danger').html('');
                        $('#personal-details-form').find('.is-invalid').removeClass('is-invalid');
                        $('#btnperDel').prop('disabled', true);
                    },
                    error: function(xhr, status, error) {
                        $("#btnperDel").prop('disabled', false).html('SAVE CHANGES');
                        // Handle error response
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            var inputField = $('#personal-details-form').find('[name="' + key + '"]');
                            // Display the error message within the input field
                            inputField.next('.text-danger').html(value[0]);
                            // Add is-invalid class to highlight the field
                            inputField.addClass('is-invalid');
                            toastr.error(value[0]);
                        });
                    }
                });
            });

            // send shipping details
            $('#btnShippInfo').prop('disabled', true);

            // Enable the submit button when any input field changes
            $('#shipping-form input').on('input', function() {
                $('#btnShippInfo').prop('disabled', false);
            });
            $('#shipping-form select').on('input', function() {
                $('#btnShippInfo').prop('disabled', false);
            });

            $('#shipping-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                // Send Ajax request
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'PUT',
                    data: formData,
                    beforeSend: function(){
                        $("#btnShippInfo").prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        `);
                        $('#btnShippInfo').css('width', '154px');
                        $('#btnShippInfo').css('height', '41px');
                    },
                    success: function(response) {
                        $("#btnShippInfo").prop('disabled', false).html('SAVE CHANGES');
                        toastr.success('Your Shipping Information is Updated', '', {"positionClass": "toast-top-right", "closeButton": true});
                        $('#btnShippInfo').prop('disabled', true);
                    },
                    error: function(xhr, status, error) {
                        $("#btnShippInfo").prop('disabled', false).html('SAVE CHANGES');
                        // Handle error response
                        var errors = xhr.responseJSON.errors;
                        console.log(errors)
                    }
                });
            });

            // change password
            $('#changePass').prop('disabled', true);

            // Enable the submit button when any input field changes
            $('#passwordForm input').on('input', function() {
                $('#changePass').prop('disabled', false);
            });

            $('#passwordForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                // Send Ajax request
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'PUT',
                    data: formData,
                    beforeSend: function(){
                        $("#changePass").prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        `);
                        $('#changePass').css('width', '154px');
                        $('#changePass').css('height', '41px');
                    },
                    success: function(response) {
                        $("#changePass").prop('disabled', false).html('SAVE CHANGES');
                        toastr.success('Your Password is changed', '', {"positionClass": "toast-top-right", "closeButton": true});
                        $('#passwordForm').find('.text-danger').html('');
                        $('#passwordForm').find('.is-invalid').removeClass('is-invalid');
                        $('#changePass').prop('disabled', true);

                        setTimeout(() => {
                            window.location = '/';
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        $("#changePass").prop('disabled', false).html('SAVE CHANGES');
                        // Handle error response
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            var inputField = $('#passwordForm').find('[name="' + key + '"]');
                            inputField.next('.text-danger').html(value[0]);
                            // Add is-invalid class to highlight the field
                            inputField.addClass('is-invalid');
                            toastr.error(value[0]);
                        });
                    }
                });
            });

        });
    </script>

    {{-- profile picture update & upload --}}
    @if( Auth::check() )
        @if( !is_null(Auth::user()->image) )
            <script>
                function upProfileValidation(){
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
                            input.value = null; 
                            toastr.error('Please Select a Valid Image Type', '', {"positionClass": "toast-top-right", "closeButton": true});
                            form['btnAdd'].onclick = (e) => {
                                e.preventDefault();
                                emptyFile();
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
                }
                
                upProfileValidation()

                //update profile
                $(document).on('click', '#upProPic', function() {
                    var $form = $(this).closest('.profileImageUpload');
                    var formData = new FormData($form[0]); // Use FormData for file uploads

                    $.ajax({
                        type: 'POST', // Corrected to 'PUT'
                        url: $form.attr('action'),
                        data: formData,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Prevent jQuery from setting content type
                        beforeSend: function() {
                            $("#upProPic").prop('disabled', true).html(`
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            `);
                            $('#upProPic').css('width', '162px');
                            $('#upProPic').css('height', '46px');
                        },
                        success: function(response) {
                            $("#upProPic").prop('disabled', false).html(`
                                Update Profile
                            `);
                            upProfileValidation();
                            toastr.success(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                            $('.profile-image').html(response.html);
                            
                            $('.modal-backdrop.show').css('visibility', 'hidden');
                            $('.modal-backdrop.show').css('opacity', 0);
                        },
                        error: function(){
                            $("#upProPic").prop('disabled', false).html(`Update Profile`);
        
                            if (xhr.status === 422) {
                                // Validation error, display toastr messages for each error
                                var errors = xhr.responseJSON.errors;
                                Object.keys(errors).forEach(function (key) {
                                    toastr.error(errors[key][0]);
                                });
                            } else {
                                // Other errors, show a generic error message
                                toastr.error('An error occurred. Please try again later.');
                            }
                        }
                    });
                });

            </script>
        @else
            <script>
                function profileValidation(){
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
                                input.value = null; 
                                toastr.error('Please Select a Valid Image Type', '', {"positionClass": "toast-top-right", "closeButton": true});
                                form['btnAdd'].onclick = (e) => {
                                    e.preventDefault();
                                    // toastr.error('Please Select a Valid Image Type', '', {"positionClass": "toast-top-right", "closeButton": true});
                                    emptyFile()
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
                }
                profileValidation();
        
                //upload profile
                $(document).on('click', '#upProPic', function() {
                    var $form = $(this).closest('.profileImageUpload');
                    var formData = new FormData($form[0]); // Use FormData for file uploads
        
                    $.ajax({
                        type: 'POST', // Corrected to 'PUT'
                        url: $form.attr('action'),
                        data: formData,
                        processData: false, // Prevent jQuery from processing data
                        contentType: false, // Prevent jQuery from setting content type
                        beforeSend: function() {
                            $("#upProPic").prop('disabled', true).html(`
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            `);
                            $('#upProPic').css('width', '162px');
                            $('#upProPic').css('height', '46px');
                        },

                        success: function(response) {
                            $("#updateProPic").prop('disabled', false).html(`
                                Update Profile
                            `);
                            // profileValidation();
                            toastr.success(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                            $('.profile-image').html(response.html);
                            
                            $('.modal-backdrop.show').css('visibility', 'hidden');
                            $('.modal-backdrop.show').css('opacity', 0);

                            // $('#hoyja').load('path/to/my-profile #hoyja', function(response, status, xhr) {
                            //     if (status == "error") {
                            //         var msg = "Sorry but there was an error: ";
                            //         console.log(msg + xhr.status + " " + xhr.statusText);
                            //     } else {
                            //         // Content loaded successfully, perform actions here
                            //     }
                            // });
                        },

                        error: function(){
                            $("#upProPic").prop('disabled', false).html(`
                                Upload Profile
                            `);
                        }
                    });
                });
        
            </script>
        @endif
    @endif
            
    <script>
        // delete profile
        $(document).ready(function() {
            $('.delProfilePic').click(function() {
            var $form = $(this).closest('.delProfilePicForm');
            var $button = $(this);
            var formData = $form.serialize();

                $.ajax({
                    type: 'DELETE',
                    url: $form.attr('action'),
                    data: formData,
                    beforeSend : function()
                    {
                       
                    },
                    success: function(response) {
                        toastr.success(response.msg, '', {"positionClass": "toast-top-right", "closeButton": true});
                        $('.profile-image').html(response.html);

                        $('.modal-backdrop.show').css('visibility', 'hidden');
                        $('.modal-backdrop.show').css('opacity', 0);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                       console.log(errorThrown)
                    }
                });
            });
        });
    </script>
    
@endsection
           

  