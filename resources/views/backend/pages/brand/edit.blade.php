@extends('backend.layout.template')

@section('page-title')
    <title>Edit Brand || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
                        <li class="breadcrumb-item active" aria-current="page">Edit Brand</li>
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
                    <h5 class="heading">Update Brand Information</h5>
                    </div>

                    <div class=" mb-3 border p-3 radius-10">
                        <!-- Message -->
                        @include('backend.includes.message')
                        <form action="{{ route('update-brand', $editData->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-lg-5">
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Brand Name</label>
                                        <input type="text" name="name" id="name" placeholder="Enter Brand Name" value="{{ $editData->name }}" class="@error('name') is-invalid @enderror">
                                        @error('name')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8">
                                                <label for="">Brand Logo</label>
                                                @if( !is_null($editData->image) )
                                                    <div class="img-box">
                                                        <div class="has-img">
                                                            <img src="{{ asset('uploads/brands/' . $editData->image) }}" alt="" id="upImg" >
                                                            
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
                                                @else
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
                                                @endif
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="mb-4">
                                        <label for="description">Brand Description</label>
                                        <textarea name="description" id="description" placeholder="Write Description.." class="">{{ $editData->description }}</textarea>
                                    </div>
                                    <div>
                                        <input type="submit" name="submit" value="Save Changes">
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        @if( !is_null($editData->image) )
                            <form action="{{ route('remove-brand-logo',  ['id' => $editData->id]) }}" method="POST" name="remove-img" class="remove-img" id="removeImg">
                                @csrf
                                <input type="hidden" name="remove_image" value="1">
                                <button type="submit"  id="btnRemoveImage">
                                    <i class="fadeIn animated bx bx-x"></i>
                                </button>
                            </form> 
                        @endif
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

        const img         = document.getElementById("upImg");
        const input       = document.querySelector(".image-upload");
        const btnRemove   = document.querySelector('.removeImg');
        const removeImage = document.getElementById('btnRemoveImage');
        const hasImg      = document.querySelector('.has-img');
        const form        = document.forms['remove-img']

        if(form && hasImg){
            hasImg.prepend(form)
        }
        window.addEventListener('load',() => {
            form.style.display = "block";
        })
        
        input.addEventListener("change", () => {
            img.src = URL.createObjectURL(input.files[0]);
            img.classList.add('userImg');
            btnRemove.style.display = "block";
            if(removeImage){
                removeImage.style.zIndex = "-1";
            }
        }); 

        btnRemove.addEventListener('click', function(){
            img.src = "{{ asset('backend/images/no-img.png') }}";
            img.classList.remove('userImg');
            input.value = null; 
            this.style.display = "none";
            if(removeImage){
                img.src = "{{ asset('uploads/brands/' . $editData->image) }}";
                removeImage.style.zIndex = "1";
            }
        })
	</script>

    {{-- delete image --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            $('#removeImg').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response){
                        toastr.error('Brand Logo is Deleted');
                        $('#upImg').attr('src', '{{ asset("backend/images/no-img.png") }}');
                        $('#upImg').css({
                            'width': '50%', 
                            'height': '42%' 
                        });
                        $('.image-upload').on('change', () => {
                            $('#upImg').css({
                                'width': '100%', 
                                'height': '100%' 
                            });
                            $('.removeImg').on('click', () => {
                                $('#upImg').attr('src', '{{ asset("backend/images/no-img.png") }}');
                                $('#upImg').css({
                                    'width': '50%', 
                                    'height': '42%' 
                                 });
                            })
                        })
                        $('#removeImg').remove();
                    },
                    error: function(xhr, status, error){
                        console.error(error);
                    }
                });
            });
        });

    </script>
@endsection
