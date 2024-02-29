@extends('backend.layout.template')

@section('page-title')
    <title>General Settings || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title> 
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}"/>
    {{-- <link rel="stylesheet" href="{{ asset('backend/css/table.css') }}"/> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('body-content')
    <div class="page-content genarelSettings"> 
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
                        <li class="breadcrumb-item active" aria-current="page">General Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        {{-- base shipping method --}}
        <div class="row">
            <div class="col-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="heading">General Settings</h5>
                            </div>
                        </div>
                        
                        <hr>

                        <form action="{{ route('genarelSettings-update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row settings g-lg-5">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="site_title">Shop Title</label>
                                        <input type="text" name="site_title" id="site_title" value="{{ (isset($GenarelSettings->site_title)) ? $GenarelSettings->site_title : '' }}" placeholder="Site Title">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" value="{{ $GenarelSettings->email }}" placeholder="Shop Email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="number1">Phone no. 1</label>
                                        <input type="text" name="number1" id="number1" value="{{ $GenarelSettings->number1 }}" placeholder="Phone no. 1">
                                    </div>
                                    <div class="mb-3">
                                        <label for="number2">Phone no. 2</label>
                                        <input type="text" name="number2" id="number2" value="{{ $GenarelSettings->number2 }}" placeholder="Phone no. 2">
                                    </div>
                                    <div>
                                        <input type="submit" value="Save Changes">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Fav Icon</label>
                                            @if( !is_null($GenarelSettings->fav_icon) )
                                                <div class="img-box">
                                                    <div class="has-img favicon">
                                                        <img src="{{ asset('uploads/fav_logo/' . $GenarelSettings->fav_icon) }}" alt="" id="upImg">
                                                        <i class="fadeIn animated bx bx-x hasRemove" id="removeIcon"></i>
                                                    </div>
                                                    <div class="upload-options">
                                                        <input type="file" name="fav_icon" class="fav_icon" accept="image/jpeg, image/png" value="{{ $GenarelSettings->fav_icon }}">
                                                        <i class="lni lni-circle-plus"></i>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="hasRemove" id="hasRemove" value="">
                                                @error('fav_icon')
                                                    <span class="text-danger" style="text-align: center">{{ $message }}</span>
                                                @enderror
                                            @else
                                                <div class="img-box">
                                                    <div class="upload-img">
                                                        <img src="{{ asset('backend/images/no-img.png') }}" alt="" id="upImg">
                                                        <i class="fadeIn animated bx bx-x removeImg"></i>
                                                    </div>
                                                    <div class="upload-options">
                                                        <input type="file" name="fav_icon" class="fav_icon" accept="image/jpeg, image/png">
                                                        <i class="lni lni-circle-plus"></i>
                                                    </div>      
                                                </div>
                                                @error('fav_icon')
                                                    <span class="text-danger" style="text-align: center">{{ $message }}</span>
                                                @enderror
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label>Site Logo</label>
                                            @if( !is_null($GenarelSettings->logo) )
                                                <div class="img-box">
                                                    <div class="has-img logoImg">
                                                        <img src="{{ asset('uploads/fav_logo/' . $GenarelSettings->logo) }}" alt="" id="backImg">
                                                        <i class="fadeIn animated bx bx-x hasbackRemove" id="hasbackRemove"></i>
                                                    </div>
                                                    <div class="upload-options">
                                                        <input type="file" name="logo" class="back-upload" accept="image/jpeg, image/png" value="{{ $GenarelSettings->logo }}"/>
                                                        <i class="lni lni-circle-plus"></i>
                                                    </div>      
                                                </div>
                                                <input type="hidden" name="hasLogoRemove" id="hasLogoRemove" value="">
                                            @else
                                                <div class="img-box">
                                                    <div class="upload-img">
                                                        <img src="{{ asset('backend/images/no-img.png') }}" alt="" id="backImg">
                                                        <i class="fadeIn animated bx bx-x backRemove"></i>
                                                    </div>
                                                    <div class="upload-options">
                                                        <input type="file" name="logo" class="back-upload" accept="image/jpeg, image/png" />
                                                        <i class="lni lni-circle-plus"></i>
                                                    </div>      
                                                </div>
                                            @endif
                                            @error('logo')
                                                <span class="text-danger" style="text-align: center">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>   
@endsection

@section('page-script')

    {{-- upload image --}}
    <script>
        // upload fav icon
        const img = document.getElementById("upImg");
        const thumbInput = document.querySelector(".fav_icon");

        @if( !is_null($GenarelSettings->fav_icon) )
            const hasRemoveIcon = document.getElementById('removeIcon');
            const hasRemoveInput = document.getElementById('hasRemove');
            hasRemoveIcon.addEventListener('click', () => {
                img.src = "{{ asset('backend/images/no-img.png') }}";
                thumbInput.value = ''; 
                img.style.width = '50%';
                img.style.height = '42%';
                hasRemoveInput.value = 1;
                hasRemoveIcon.style.display = "none";
            });

            thumbInput.addEventListener("change", () => {
                img.src = URL.createObjectURL(thumbInput.files[0]);
                img.style.width = '62px';
                img.classList.add('userImg');
                hasRemoveInput.value = ''; 
                hasRemoveIcon.style.display = "block";
            });
        @endif

        @if( is_null($GenarelSettings->fav_icon) )
            const btnRemove = document.querySelector('.removeImg');
            btnRemove.addEventListener('click', function(){
                img.src = "{{ asset('backend/images/no-img.png') }}";
                img.classList.remove('userImg');
                thumbInput.value = null; 
                this.style.display = "none";
            });

            thumbInput.addEventListener("change", () => {
                img.src = URL.createObjectURL(thumbInput.files[0]);
                img.style.width = '62px';
                img.classList.add('userImg');
                btnRemove.style.display = "block";
            });
        @endif
        
        // logo upload
        const backImg    = document.getElementById("backImg");
        const backInput  = document.querySelector(".back-upload");

        @if( !is_null($GenarelSettings->logo) )
            const hasbackRemoveIcon  = document.getElementById('hasbackRemove');
            const hasbackRemoveInput = document.getElementById('hasLogoRemove');
            hasbackRemoveIcon.addEventListener('click', () => {
                backImg.src = "{{ asset('backend/images/no-img.png') }}";
                backInput.value = ''; 
                backImg.style.width = '50%';
                backImg.style.height = '42%';
                hasbackRemoveInput.value = 1;
                hasbackRemoveIcon.style.display = "none";
            });

            backInput.addEventListener("change", () => {
                backImg.src = URL.createObjectURL(backInput.files[0]);
                backImg.style.width = '80%';
                backImg.classList.add('userImg');
                hasbackRemoveIcon.value = ''; 
                hasbackRemoveIcon.style.display = "block";
            });
        @endif

        @if( is_null($GenarelSettings->logo) )
            const backRemove  = document.querySelector('.backRemove')
            backInput.addEventListener("change", () => {
                backImg.src = URL.createObjectURL(backInput.files[0]);
                backImg.style.width = '80%';
                backImg.classList.add('userImg');
                backRemove.style.display = "block";
            }); 

            backRemove.addEventListener('click', function(){
                backImg.src = "{{ asset('backend/images/no-img.png') }}";
                backImg.classList.remove('userImg');
                backInput.value = null; 
                this.style.display = "none";
            }) 
        @endif

    </script>

    <script>
        
    </script>
    
@endsection
