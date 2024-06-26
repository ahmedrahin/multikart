@extends('backend.layout.template')

@section('page-title')
    <title>Add New Brand || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <style>
        .col-md-6{
            margin-top: 3rem !important;
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
                        <li class="breadcrumb-item active" aria-current="page">Create Brand</li>
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
                            <h5 class="heading">Add New Brand</h5>
                        </div>

                        <div class="border p-3 radius-10">
                            <!-- Message -->
                            @include('backend.includes.message')
                            <form action="{{ route('store-brand') }}" method="POST" enctype="multipart/form-data" id="addBrand">
                                @csrf
                                <div class="row g-lg-5">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label for="name">Brand Name</label>
                                            <input type="text" name="name" id="name" placeholder="Enter Brand Name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
                                            @error('name')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="">Brand Logo</label>
                                                    <div class="img-box">
                                                        <div class="upload-img">
                                                            <img src="{{ asset('backend/images/no-img.png') }}" alt="" id="upImg">
                                                            <i class="fadeIn animated bx bx-x removeImg"></i>
                                                        </div>
                                                        <div class="upload-options">
                                                            <input type="file" name="image" class="image-upload" accept="image/jpeg, image/png" />
                                                            <i class="lni lni-circle-plus"></i>
                                                        </div>      
                                                    </div>
                                                    @error('image')
                                                        <span class="text-danger" style="text-align: center">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>                               
                                        </div>  
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-4">
                                            <label for="description">Brand Description</label>
                                            <textarea name="description" id="description" class=" @error('name') is-invalid @enderror" placeholder="Write Description..">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input type="submit" name="submit" value="Add Brand">
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
    </div>        
@endsection

@section('page-script')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace( 'description' );
		})

        // upload image
        const img    = document.getElementById("upImg");
        const input = document.querySelector(".image-upload");
        const btnRemove = document.querySelector('.removeImg')
        input.addEventListener("change", () => {
            img.src = URL.createObjectURL(input.files[0]);
            img.classList.add('userImg');
            btnRemove.style.display = "block";
        }); 

        btnRemove.addEventListener('click', function(){
            img.src = "{{ asset('backend/images/no-img.png') }}";
            img.classList.remove('userImg');
            input.value = null; 
            this.style.display = "none";
        }) 
    </script>
@endsection
