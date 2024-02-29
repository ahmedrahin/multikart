@extends('backend.layout.template')

@section('page-title')
    <title>Add New Product || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('body-content')
    <div class="page-content upProduct">
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
                        <li class="breadcrumb-item active" aria-current="page">Create Product</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card product">
            <form action="{{ route('store-product') }}" method="POST" enctype="multipart/form-data" name="addProduct">
                @csrf
                <div class="card-body p-4">
                    <h5 class="heading">Add New Product</h5>
                    <hr>
                    <!-- Message -->
                    @include( 'backend.includes.message' )
                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputProductTitle">Product Title</label>
                                        <input type="text" name="title" id="inputProductTitle" placeholder="Enter Product Title" value="{{ old('title')}}" class="@error('title') is-invalid @enderror">
                                        @error('title')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="shotDes">Short Description</label>
                                        <textarea id="description" name="short_description" placeholder="Write Short Description.." class="@error('short_description') is-invalid @enderror">{{ old('short_description')}}</textarea>
                                        @error('short_description')
                                                <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="longDes">Product Details</label>
                                        <textarea id="description2" name="long_description" placeholder="Write Long Description..">{{ old('long_description')}}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <div class="row g-md-4">
                                            <div class="col-lg-6">
                                                <label for="">Thumbnail Image</label>
                                                <div class="img-box">
                                                    <div class="upload-img">
                                                        <img src="{{ asset('backend/images/no-img.png') }}" alt="" id="upImg">
                                                        <i class="fadeIn animated bx bx-x removeImg"></i>
                                                    </div>
                                                    <div class="upload-options">
                                                        <input type="file" name="thumb_image" class="thumb-upload" accept="image/jpeg, image/png" />
                                                        <i class="lni lni-circle-plus"></i>
                                                    </div>      
                                                </div>
                                                @error('thumb_image')
                                                    <span class="text-danger" style="text-align: center">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6">
                                                <label for="">Back Side Image</label>
                                                <div class="img-box">
                                                    <div class="upload-img">
                                                        <img src="{{ asset('backend/images/no-img.png') }}" alt="" id="backImg">
                                                        <i class="fadeIn animated bx bx-x backRemove"></i>
                                                    </div>
                                                    <div class="upload-options">
                                                        <input type="file" name="back_image" class="back-upload" accept="image/jpeg, image/png" />
                                                        <i class="lni lni-circle-plus"></i>
                                                    </div>      
                                                </div>
                                                @error('back_image')
                                                    <span class="text-danger" style="text-align: center">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Product Images</label>
                                        <div class="AppBody">
                                            <div class="icon">
                                                <i class="bx bxs-cloud-upload"></i>
                                            </div>
                                             <h3 class="dragText">Drag&Drop Your File(s)Here To Upload</h3>
                                            <button type="button" id="btnMultipleImage">or select file to upload</button>
                                            <input type="file" id="multipleImage" name="images[]" accept="image/jpeg, image/png" multiple hidden>
                                            <div class="items">
                                                
                                            </div>
                                        </div>                                    
                                    </div>
                                    
                                </div>
                            </div>
                        
                            <div class="col-lg-5">
                                <div class="border border-3 p-4 rounded">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="regular_price">Regular Price</label>
                                        <input type="number"  id="regular_price" name="regular_price" value="{{ old('regular_price') }}" placeholder="00.00" class="@error('regular_price') is-invalid @enderror">
                                        @error('regular_price')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                        <span class="text-danger regularPriceError">  </span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="offer_price">Offer Price</label>
                                        <input type="number" name="offer_price" id="offer_price" value="{{ old('offer_price') }}" placeholder="00.00" class="@error('offer_price') is-invalid @enderror">
                                        @error('offer_price')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                        <span class="text-danger offerPriceError">  </span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sku_code">Sku Code</label>
                                        <input type="text" name="sku_code" id="sku_code" value="{{ old('sku_code')}}" placeholder="Sku code">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity')}}" placeholder="00" class="@error('quantity') is-invalid @enderror">
                                        @error('quantity')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label>Video Link</label>
                                        <input type="text" name="video_link" value="{{ old('video_link')}}"  placeholder="https://youtube.com..">
                                    </div>

                                    <div class="col-12">
                                        <label>Category</label>
                                        <select name="category_id" class="@error('category_id') is-invalid @enderror selectCategory" value="{{ old('category_id') }}" id="categoryId">
                                            <option value="">Select the Parent Category</option>
                                            @foreach( $categories as $category )
                                                <option value="{{ $category->id }}">{{  $category->name }}</option>                  
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label>Sub Category</label>
                                        <select name="subCategory_id" class="@error('subCategory_id') is-invalid @enderror selectSubCategory" value="{{ old('subCategory_id') }}" id="subCategoryId" disabled>
                                            <option value="">Select the Sub Category</option>
                                        </select>
                                        @error('subCategory_id')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label>Product Brand</label>
                                        <select name="brand_id" class="selectBrand">
                                            <option value="0">Select the Brand Name</option>
                                            @foreach( $brandList as $brand )
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label>Featured Product</label>
                                        <select name="is_featured" value="{{ old('is_featured') }}" class="selectFeature">
                                            <option value="0">Select the Featured Status</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label>Product Status</label>
                                        <select name="status" value="{{ old('status') }}" class="selectStatus">
                                            <option value="1">Select the Product Status</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <div class="tag-wrapper">
                                            <div class="title">
                                            <img src="{{ asset('backend/images/tag.svg') }}" alt="icon">
                                            <h2>Tags</h2>
                                            </div>
                                            <div class="content">
                                            <p>Press enter or add a comma after each tag</p>
                                            <ul id="tagList">
                                                <input type="text" name="tagsInput" id="tagsInput" class="tagsInput" spellcheck="false">
                                            </ul>
                                            <input type="hidden" name="tags">
                                            </div>
                                            <div class="details">
                                            <p><span></span> tags are remaining</p>
                                            <button type="button" id="removeAllTag">Remove All</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <input type="submit" id="submit" class="btn btn-primary" value="Add Product">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <br>

                            <div class="varition-container">
                                <div class="border border-3 p-4 mb-3 rounded addVarition first"  >
                                    <i class="fadeIn animated bx bx-x remove" onclick=""></i>
                                    <div class="row g-3">
                                        <div class="col-md-6"><label>Regular Price</label><input type="number" class="rprice" placeholder="00.00" ></div>
                                        <div class="col-md-6"><label>Offer Price</label><input type="number" class="oprice"   placeholder="00.00"></div>
                                        <div class="col-md-6"><label>Sku Code</label><input type="text" class="sku" placeholder="Sku code"></div>
                                        <div class="col-md-6"><label>Quantity</label><input type="number" class="qty" placeholder="00"></div>

                                        <div class="col-lg-6">
                                            <div class="var_name">
                                                <label>Variation Name</label>
                                                <select class="@error('varition') is-invalid @enderror selectVariation" id="varition">
                                                    <option value="">Select the Variation</option>
                                                    @foreach( $varitaions as $varitaion )
                                                        <option value="{{ $varitaion->id }}">{{  $varitaion->var_name }}</option>                  
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="text-danger"> {{ $message }} </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="var_option">
                                                <label>Select Option</label>
                                                <select class="@error('option') is-invalid @enderror selectOption" id="option" disabled>
                                                    <option value="">Select the Option</option>
                                                    @foreach( $options as $option )
                                                        <option value="{{ $option->id }}">{{  $option->option }}</option>                  
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="text-danger"> {{ $message }} </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Thumbnail Image</label>
                                            <input type="file" class="form-control vimage" id="" name="var_image[]"> 
                                        </div>

                                    </div>
                                </div>
                                
                            </div>
                            
                            <button type="button" class="variation"><i class="fa fa-plus-circle"></i> Add Variation</button>

                        </div>
                    </div><!--end row-->
                    </div>
                </div>
            </form>
            
        </div>  
    </div>      
@endsection

@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script> 
    <script>
		$(document).ready(function () {
			$(".selectStatus").select2();
		});
        $(document).ready(function () {
			$(".selectFeature").select2();
		});
        $(document).ready(function () {
			$(".selectBrand").select2();
		});
        $(document).ready(function () {
			$(".selectCategory").select2();
		});
        $(document).ready(function () {
			$(".selectSubCategory").select2();
		});
        
        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'description2' );
	</script>

    {{-- variation --}}
     <script>
        $(".variation").click(function() {
            var newVariation = $(".addVarition").first().clone(); 
            newVariation.find('input').val(''); 
            newVariation.find('.var_option select').html('<option value="">Select the Option</option>'); 
            newVariation.find('.var_option select').attr('disabled', true);
            newVariation.find('.var_option select').attr('name', 'option[]');

            newVariation.find('.var_name select').attr('name', 'varition[]');
            newVariation.find('.qty').attr('name', 'quantityV[]');
            newVariation.find('.sku').attr('name', 'sku_codeV[]');
            newVariation.find('.oprice').attr('name', 'offer_priceV[]');
            newVariation.find('.rprice').attr('name', 'regular_priceV[]');
            // newVariation.find('.vimage').attr('name', 'var_image[]');
            newVariation.removeClass('first');
            $(".varition-container").append(newVariation.addClass('new')); 
            newVariation.find(".selectVariation").select2();
            newVariation.find(".selectOption").select2();

        }); 

        $(document).on("click", ".remove", function() {
            $(this).closest('.addVarition').remove();
        });

        $(".varition-container").on("change", ".selectVariation", function() {
            let varitionId = $(this).val();
            let varOption = $(this).closest(".addVarition").find(".var_option select");

            if (varitionId !== "" && varitionId !== "0") {
                $.get("/get-option/" + varitionId, function(data) {
                    let allData = JSON.parse(data);
                    if (allData.length === 0) {
                        varOption.html('<option value="">No option available</option>');
                    } else {
                        let optionsHtml = allData.map(element => `<option value="${element.id}">${element.option}</option>`).join("");
                        varOption.html(optionsHtml);
                    }
                    varOption.removeAttr("disabled");
                });
            } else {
                varOption.html('<option value="">Select the Option</option>').attr("disabled", "disabled");
            }
        });
     </script>

    {{-- category and subcategory --}}
    <script>
        $("#categoryId").change(function(){
            // Get category id
            let categoryId = $(this).val();

            // Initiate subcategory
            let allOptions = '';
            
            if( categoryId != 0  || categoryId != "" ){
                $.get("/get-subcategory/" + categoryId, function(data){
                    allData = JSON.parse(data);
                    if (allData.length === 0) {
                        $("#subCategoryId").html('<option value="">No subcategories available</option>');
                    } else {
                        allData.forEach( function(element){
                            allOptions += `<option value="${element.id}">${element.name}</option>`;
                        });
                        $("#subCategoryId").html(allOptions);
                    }
                    $("#subCategoryId").removeAttr("disabled");
                });
            }else{
                $("#subCategoryId").html('<option value="">Select the Sub Category</option>');
                $("#subCategoryId").attr("disabled", "disabled");
            }
        });
    </script>

    {{-- offer price < regular price --}}
    <script>
        try{
            document.addEventListener('DOMContentLoaded', function() {
                let regularPrice = document.getElementById('regular_price');
                let offerPrice = document.getElementById('offer_price');
                let error = document.querySelector('.offerPriceError');
                let regError = document.querySelector('.regularPriceError');
                let errorShown = false;

                offerPrice.addEventListener('input', (e) => {
                    let val = parseFloat(e.target.value);
                    let regularVal = parseFloat(regularPrice.value);

                    if (val >= regularVal ) {
                        if (!errorShown) {
                            error.innerText = "The offer price must be lower than the regular price";
                            toastr.warning('The offer price must be lower than the regular price', '', {"positionClass": "toast-top-right", "closeButton": true});
                            errorShown = true;
                        }
                    }
                    else if( isNaN(val) || val < 0 ){
                        error.innerText = "Offer price should be a valid positive number.";
                        errorShown = true;
                    } 
                    else {
                        error.innerText = "";
                        toastr.clear();
                        errorShown = false;
                    }

                });

                regularPrice.addEventListener('input', (e) => {
                    let val = parseFloat(e.target.value);
                    let offerVal = parseFloat(offerPrice.value);

                    if (offerVal >= val ) {
                        if (!errorShown) {
                            error.innerText = "The offer price must be lower than the regular price";
                            toastr.warning('The offer price must be lower than the regular price', '', {"positionClass": "toast-top-right", "closeButton": true});
                            errorShown = true;
                        }
                    }
                    else if( isNaN(val) || val < 0 ){
                        regError.innerText = "Regular price should be a valid positive number.";
                        errorShown = true;
                    } 
                    else {
                        error.innerText = "";
                        regError.innerText = "";
                        toastr.clear();
                        errorShown = false;
                    }

                });
            });
        }catch(err){
            console.log(err.message);
        }
    </script>

    {{-- meta tag --}}
    <script>
        window.addEventListener('load', function(){
            window.scrollTo(0, 0);
            document.getElementById('inputProductTitle').focus();
        })

        let tagsInput = document.getElementById('tagsInput');
        tagsInput.addEventListener('focus', function() {
            this.parentElement.style.border = '2px solid #5E72E4';
        });
        tagsInput.addEventListener('blur', function() {
            this.parentElement.style.border = '';
        });

        const ul   = document.querySelector("#tagList"),
        input      = document.querySelector(".tagsInput"),
        tagNumb    = document.querySelector(".details span");
        let maxTag = 5,
        tags  = [];
        countTag()

        const tagInput = document.querySelector('[name="tags"]');
        function updateInputValue() {
            tagInput.value = tags.join(', ');
        }

        function countTag(){
            input.focus();
            tagNumb.innerText =  maxTag - tags.length;
        }
        
        function createTag(){
            ul.querySelectorAll('li').forEach( li => li.remove() );
            tags.slice().reverse().forEach( tag => {
                let list = `<li> ${tag} <i class="uit uit-multiply" onclick="removeTag(this, '${tag}')"></i></li>`;
                ul.insertAdjacentHTML('afterbegin', list);
            })
            countTag();
            updateInputValue();
        }

        function removeTag(el, tag){
            let index = tags.indexOf(tag);
            tags = [...tags.slice(0,index), ...tags.slice(index + 1)];
            el.parentElement.remove();
            countTag();
            updateInputValue();
        }

        function addTag(e) {
            if (e.key === "Enter") {
                let tagsInputValue = e.target.value.replace(/\s+/g, ''); 
                let newTags = tagsInputValue.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);

                newTags.forEach(tag => {
                    if (tags.length < maxTag && !tags.includes(tag)) {
                        tags.push(tag);
                        createTag();
                        toastr.clear();
                    } else if (tags.includes(tag)) {
                        if( tags.length > maxTag ){
                            tagsInput.parentElement.style.border = '2px solid red';
                            toastr.warning('Maximum 5 tags', '', {"positionClass": "toast-top-right", "closeButton": true});
                        }else {
                            toastr.info('The tag already exists', '', {"positionClass": "toast-top-right", "closeButton": true});
                        }
                    } else {
                        tagsInput.parentElement.style.border = '2px solid red';
                        toastr.warning('Maximum 5 tags', '', {"positionClass": "toast-top-right", "closeButton": true});
                    }
                });
                e.target.value = "";
            }
        }

        input.addEventListener('keyup', addTag);

        const removeAllTag = document.querySelector('#removeAllTag');
            removeAllTag.onclick = () => {
                tags.length = 0;
                ul.querySelectorAll('li').forEach( li => li.remove() );
                countTag();
                updateInputValue();
            }

        document.addEventListener('DOMContentLoaded', function() {
            const addProductForm = document.forms['addProduct'];
            addProductForm.addEventListener('submit', function(e) {
                const activeElement = document.activeElement;
                if (activeElement.tagName.toLowerCase() === 'input' && activeElement.name === 'tagsInput') {
                    e.preventDefault(); 
                }
            });
        });
    </script>

    {{-- drag & drop multiple image --}}
    <script>

        let btnMultipleImage = document.getElementById('btnMultipleImage');
        let multipleImage    = document.getElementById('multipleImage');
        let items            = document.querySelector('.items');
        let dragText         = document.querySelector('.dragText');
        let AppBody          = document.querySelector('.AppBody')
        let files            = [];

        btnMultipleImage.addEventListener('click', () => multipleImage.click());
        multipleImage.addEventListener('change', () => {
            let file = multipleImage.files;
            for(let i = 0; i < file.length; i++){
                if (files.every(e => e.name !== file[i].name)) {
                    if (file[i].type === 'image/jpeg' || file[i].type === 'image/png') {
                        files.push(file[i]);
                    } else {
                        toastr.warning('Please select only PNG or JPG images', '', {"positionClass": "toast-top-right", "closeButton": true});
                    }
                }
            }
            showImages();
        });

        const showImages = () => {
            let images = '';
            files.forEach( (e, i) => {
                images += `<div class="item">
                                <span onclick='delImage(${i})'><i class="fa fa-times" aria-hidden="true"></i></span>
                                <img src="${URL.createObjectURL(e)}" alt="">
                            </div>`;      
            });
            items.innerHTML = images;
        };

        const delImage = (index) => {
            files.splice(index, 1);

            const dataTransfer = new DataTransfer();
            files.forEach(file => {
                dataTransfer.items.add(file);
            });
            multipleImage.files = dataTransfer.files;
            showImages();
        };
        showImages();
        AppBody.addEventListener('dragover', (e) => {
            e.preventDefault();
            AppBody.classList.add('dragover');
            dragText.innerText = "Drop Images Here";
        });
        AppBody.addEventListener('dragleave', (e) => {
            e.preventDefault();
            AppBody.classList.remove('dragover');
            dragText.innerText = "Drag&Drop Your File(s)Here To Upload";
        });
        AppBody.addEventListener('drop', (e) => {
            e.preventDefault();
            AppBody.classList.remove('dragover');
            dragText.innerText = "Drag&Drop Your File(s)Here To Upload";

            let file = e.dataTransfer.files;

            for (let i = 0; i < file.length; i++) {
                if (files.every(e => e.name !== file[i].name)) {
                    if (file[i].type === 'image/jpeg' || file[i].type === 'image/png') {
                        files.push(file[i]);
                    } else {
                        toastr.warning('Please only drop PNG or JPG images', '', {"positionClass": "toast-top-right", "closeButton": true});
                    }
                }
            }
            showImages();
        });

    </script>

    {{-- upload image --}}
    <script>
        // upload thumb
        const img    = document.getElementById("upImg");
        const thumbInput = document.querySelector(".thumb-upload");
        const btnRemove = document.querySelector('.removeImg')
        thumbInput.addEventListener("change", () => {
            img.src = URL.createObjectURL(thumbInput.files[0]);
            img.classList.add('userImg');
            btnRemove.style.display = "block";
        }); 

        btnRemove.addEventListener('click', function(){
            img.src = "{{ asset('backend/images/no-img.png') }}";
            img.classList.remove('userImg');
            thumbInput.value = null; 
            this.style.display = "none";
        });
        
        // back image upload
        const backImg    = document.getElementById("backImg");
        const backInput  = document.querySelector(".back-upload");
        const backRemove  = document.querySelector('.backRemove')
        backInput.addEventListener("change", () => {
            backImg.src = URL.createObjectURL(backInput.files[0]);
            backImg.classList.add('userImg');
            backRemove.style.display = "block";
        }); 

        backRemove.addEventListener('click', function(){
            backImg.src = "{{ asset('backend/images/no-img.png') }}";
            backImg.classList.remove('userImg');
            backInput.value = null; 
            this.style.display = "none";
        }) 
    </script>

@endsection
