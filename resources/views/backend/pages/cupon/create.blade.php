@extends('backend.layout.template')

@section('page-title')
    <title>Add New Coupon || {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}</title>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/css/jquery.datetimepicker.min.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
@endsection

@section('body-content')
    <div class="page-content upProduct addCoupon">
         <!--breadcrumb-->
         <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-4">
            <div class="breadcrumb-title pe-3">
                {{ !is_null($siteTitle = App\Models\Settings::site_title()) ? $siteTitle->site_title : 'Shop' }}
            </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Coupon</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card product">
            <form action="{{ route('store-cupons') }}" method="POST">
                @csrf
                <div class="card-body p-4">
                    <h5 class="heading">Add New Coupon</h5>
                    <hr>
                    <!-- Message -->
                    @include( 'backend.includes.message' )
                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">
                                    
                                    <div class="mb-3">
                                        <label for="inputProductTitle">Coupon Title</label>
                                        <input type="text" name="title" id="inputProductTitle" placeholder="Enter Coupon Title" value="{{ old('title')}}" class="@error('title') is-invalid @enderror">
                                        @error('title')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="code">Coupon Code</label>
                                        <input type="text" name="code" id="code" placeholder="Enter Coupon Code" value="{{ old('code')}}" class="@error('code') is-invalid @enderror">
                                        @error('code')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="damount">Discount Amount</label>
                                        <input type="number" name="damount" id="damount" placeholder="Discount Amount" value="{{ old('damount')}}" class="@error('damount') is-invalid @enderror">
                                        @error('damount')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="mamount">Min Amount</label>
                                        <input type="number" name="mamount" id="mamount" placeholder="Min Amount" value="{{ old('mamount')}}" class="@error('mamount') is-invalid @enderror">
                                        @error('mamount')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="uses">Max Uses</label>
                                        <input type="number" name="uses" id="uses" placeholder="Max Uses" value="{{ old('uses')}}" class="@error('uses') is-invalid @enderror">
                                        @error('uses')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="uses_user">Max Uses User</label>
                                        <input type="number" name="uses_user" id="uses_user" placeholder="Max Uses User" value="{{ old('uses_user')}}" class="@error('uses_user') is-invalid @enderror">
                                        @error('uses_user')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>
                        
                            <div class="col-lg-6">
                                <div class="border border-3 p-4 rounded">

                                    <div class="mb-3">
                                        <label for="start">Start At</label>
                                        <input type="text" name="start" id="start" placeholder="Start At" value="{{ old('start')}}" class="@error('start') is-invalid @enderror">
                                        <i class="fadeIn animated bx bx-calendar-star"></i>
                                        @error('start')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="expire">Expire At</label>
                                        <input type="text" name="expire" id="expire" placeholder="Expire At" value="{{ old('expire')}}" class="@error('expire') is-invalid @enderror">
                                        <i class="fadeIn animated bx bx-calendar-star"></i>
                                        @error('expire')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label>Coupon Type</label>
                                        <select name="type" id="type" class="type">
                                            <option value="">Select the Coupon type</option>
                                            <option value="percent">Percent</option>
                                            <option value="fixed">Fixed</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label>Coupon Status</label>
                                        <select name="status" class="selectStatus">
                                            <option value="1">Select the Coupon Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid" style="width: 70%">
                                            <input type="submit" id="submit" class="btn btn-primary" value="Add Coupon">
                                        </div>
                                    </div>

                            </div>
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
    <script src="{{ asset('backend/js/jquery.datetimepicker.full.min.js') }}"></script>
    
    <script>
		$(document).ready(function () {
			$(".selectStatus").select2();
			$(".type").select2();
		});
        $('#start').datetimepicker();
        $('#expire').datetimepicker();
        
	</script>

@endsection
